<?php
/*
 * Really simple database API
 * It's not fast, it's based on flat files, it does not use SQL and it's
 * not based on SQLITE.
 *
 * It's just designed to run in environments when no database is available.
 *
 * Examples:
 * $db = new Database();
 * $db->table('mytable')->insert(array('name' => 'mike')); // returns { id: 1, name: 'mike' }
 * $db->table('mytable')->find(1); // returns the same object as above
 * $db->table('mytable')->remove(1); // deletes
 * $db->table('someothertable')->order(Database::$ORDER_ASC)->limit(2)->offset(1)->all();
 */
class Database
{
    private $data_dir;
    private $query;

    /**
     * Creates a new database instance, by default, it connects
     * to 'prod' (production), but it can accept any string.
     */
    public function __construct($db = 'prod') {
        $this->data_dir = __DIR__ . '/../data/' . $db . '/';

        if(!is_dir($this->data_dir)) {
            mkdir($this->data_dir);
        }
    }

    public function table($name) {
        $this->query = new Query($name);

        // chainability
        return $this;
    }

    /**
     * Add an object to a table
     */
    public function insert($obj) {
        if(!is_array($obj)) {
            throw new Exception('Can only write arrays');
        }

        $table = $this->query->table;
        $id = 0;
        $meta = null;

        // Find the id of the new entry
        if(!is_dir($this->data_dir . $table)) {
            mkdir($this->data_dir . $table, 0777);
            $id = 1;
            // Create an empty metadata array
            $meta = array(
                'last_id' => 0,
                'count' => 0,
                'entries' => array(),
            );
        } else {
            $meta = $this->meta();
            $id = $meta['last_id'] + 1;
        }

        // Create new file
        $obj['id'] = $id;
        file_put_contents($this->data_dir . $table . '/entry_' . $id . '.php', serialize($obj), LOCK_EX);

        // Save new metadata
        $meta['last_id'] = $id;
        $meta['entries'][] = $id;
        $meta['count'] = $meta['count'] + 1;
        file_put_contents($this->data_dir . $table . '/meta.php', serialize($meta), LOCK_EX);

        // invalidate cache
        foreach(glob($this->data_dir . $table . '/cache_*') as $cache_file) {
            unlink($cache_file);
        }

        // Return the new entry data
        return $obj;
    }

    public function update($id, $val) {
        $table = $this->query->table;
        $entry_file = $this->data_dir . $table . '/entry_' . $id . '.php';
        if(!file_exists($entry_file)) {
            throw new Exception('Could not find entry with id ' . $id);
        }

        file_put_contents($entry_file, serialize($val), LOCK_EX);

        // invalidate cache
        foreach(glob($this->data_dir . $table . '/cache_*') as $cache_file) {
            unlink($cache_file);
        }

        return $val;
    }

    /*
     * Removes entry with the given id
     */
    public function remove($id) {
        $table = $this->query->table;

        if(!file_exists($this->data_dir . $table . '/entry_' . $id . '.php')) {
            throw new Exception('Could not find entry with id: ' . $id);
        }

        $meta = $this->meta();
        $key = array_search($id, $meta['entries']);
        unset($meta['entries'][$key]);
        $meta['count'] = $meta['count'] - 1;
        unlink($this->data_dir . $table . '/entry_' . $id . '.php');
        file_put_contents($this->data_dir . $table . '/meta.php', serialize($meta), LOCK_EX);

        // chainability
        return $this;
    }

    public function find($id) {
        $this->query->id = $id;
        return $this->findById();
    }

    public function order($ord) {
        $this->query->order = strtoupper($ord);

        // chainability
        return $this;
    }

    public function limit($limit) {
        $this->query->limit = $limit;

        // chainability
        return $this;
    }


    public function offset($offset) {
        $this->query->offset = $offset;

        // chainability
        return $this;
    }

    /*
     * Apply a filter to each element
     */
    public function filter($arr = null) {
        $this->query->filter = $arr;
        return $this->findAll();
    }

    /*
     * Return all elements without filter
     */
    public function all() {
        return $this->filter();
    }

    public function count() {
        $meta = $this->meta();
        return $meta['count'];
    }

    public function meta() {
        $table = $this->query->table;
        $path = $this->data_dir . $table . '/meta.php';
        if(!file_exists($path)) {
            throw new Exception("Table $table not found");
        }

        return unserialize(file_get_contents($path));
    }

    private function findById() {
        $table = $this->query->table;
        $id = $this->query->id;
        $path = $this->data_dir . $table . '/entry_' . $id . '.php';
        if(file_exists($path)) {
            return unserialize(file_get_contents($path));
        }

        return null;
    }

    private function findAll() {
        $table = $this->query->table;
        $order = $this->query->order;
        $limit = $this->query->limit;
        $offset = $this->query->offset;
        $filter = $this->query->filter;

        // seek for cache
        $cache_name = sha1($table . $order . $limit . $offset . serialize($filter));
        $cache_file = $this->data_dir . $table . '/cache_' . $cache_name . '.php';
        if(file_exists($cache_file)) {
            return unserialize(file_get_contents($cache_file));
        }

        $metadata = $this->meta();
        $entries = $metadata['entries'];

        // order
        if($order === 'DESC') {
            arsort($entries, SORT_NUMERIC);
        }

        // limit and offset
        if($limit > 0) {
            $entries = array_slice($entries, $offset, $limit);
        } else if($offset > 0) {
            $entries = array_slice($entries, $offset);
        }

        $output = array();
        $entry = null;

        if(is_null($filter)) {
            foreach($entries as $id) {
                $output[] = unserialize(file_get_contents($this->data_dir . $table . '/entry_' . $id . '.php'));
            }
        } else {
            foreach($entries as $id) {
                $entry = unserialize(file_get_contents($this->data_dir . $table . '/entry_' . $id . '.php'));
                $add = true;
                foreach($filter as $key => $value) {
                    if($entry[$key] != $value) {
                        $add = false;
                        break;
                    }
                }

                if($add) {
                    $output[] = $entry;
                }
            }
        }

        // create cache
        file_put_contents($cache_file, serialize($output), LOCK_EX);
        return $output;
    }
}

class Query
{
    public $table = null;
    public $order;
    public $limit = 0;
    public $offset = 0;
    public $id = 0;
    public $filter = null;

    public function __construct($name) {
        $this->table = $name;
        $this->order = 'ASC';
    }
}

