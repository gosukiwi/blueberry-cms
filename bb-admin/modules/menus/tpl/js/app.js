(function () {
    "use strict";

    // Utility functions
    function moveItemFromArrayUp (arr, item) {
        var i = arr.indexOf(item),
            array = arr();

        if (i >= 1) {
            arr.splice(i-1, 2, array[i], array[i-1]);
        }
    }

    function moveItemFromArrayDown (arr, item) {
        var i = arr.indexOf(item),
            array = arr();

        if(i < array.length - 1) {
            arr.splice(i, 2, array[i+1], array[i]);
        }
    }

    // Object constructors
    
    function Link(name, url) {
        this.name = ko.observable(name || '');
        this.url = ko.observable(url || '');
    }

    function MenusViewModel () {
        var self = this;

        self.types = MENU_TYPES;
        self.current_type = ko.observable(MENU_TYPES[0]);
        self.links = ko.observableArray();

        // values of the current link
        self.link_name = ko.observable();
        self.current_url = ko.observable();

        // Get items
        $.getJSON(AJAX_GET_MENU_ITEMS_URI, function (data) {
            var i, 
                len = data.length;

            // Remove all links
            self.links.removeAll();

            // Refill links array
            for(i = 0; i < len; i += 1) {
                self.links.push(new Link(data[i], 'unknown'));
            }
        });

        // Events
        self.addLink = function () {
            if(!self.link_name()) {
                return;
            }

            self.links.push(new Link(self.link_name(), self.current_url()));
            self.link_name('');
            self.current_url('');
        };

        self.removeLink = function (link) {
            self.links.remove(link);
        };

        self.moveUp = function (link) {
            moveItemFromArrayUp(self.links, link);
        };

        self.moveDown = function (link) {
            moveItemFromArrayDown(self.links, link);
        };
    }

    ko.applyBindings(new MenusViewModel());
}());
