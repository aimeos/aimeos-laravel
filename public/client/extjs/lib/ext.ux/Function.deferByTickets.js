/*!
 * Copyright (c) Metaways Infosystems GmbH, 2011
 * LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * $Id: Function.deferByTickets.js 14263 2011-12-11 16:36:17Z nsendetzky $
 */

Ext.applyIf(Function.prototype, {

    /**
     * defers execution on a ticket bases. The function gets executed when all
     * regisered tickets are back. var sayHi = function(name){ alert('Hi, ' +
     * name); } var ticketFn = sayHi.deferByTickets(this, ['Fred']); // take
     * ticket var ticketFn1 = ticketFn(); var ticketFn2 = ticketFn(); // give
     * tickets back ticketFn1(); ticketFn2(); NOTE: the function gets never
     * executed if not at least one ticket is taken and given back
     * 
     * @param {Object}
     *            scope (optional) The scope (this reference) in which the
     *            function is executed.
     * @param {Array}
     *            args (optional) Overrides arguments for the call. (Defaults to
     *            the arguments passed by the caller)
     * @param {Boolean/Number}
     *            appendArgs (optional) if True args are appended to call args
     *            instead of overriding, if a number the args are inserted at
     *            the specified position
     * @return {Function} ticketFn
     */
    deferByTickets : function(obj, args, appendArgs) {
        var fn = this.createDelegate(obj, args, appendArgs), waitTickets = [];

        // run if all tickets are back
        var run = function() {
            if(Ext.isEmpty(waitTickets)) {
                fn();
            }
        };

        return function() {
            var ticket = Ext.id();
            waitTickets.push(ticket);
            // fn to return wait ticket
            return function() {
                waitTickets.remove(ticket);
                run();
            };
        };
    }
});
