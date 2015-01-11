(function() {
    tinymce.create('tinymce.plugins.embedgist', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            ed.addButton('embedgist', {
              title : 'Embed Gist code',
              cmd : 'embedgist',
              image : url + '/mce-button.png'
            });

            ed.addCommand('embedgist', function() {
              ed.windowManager.open({
                title: 'Embed Github Gist Code',
                body: [
                    {type: 'textbox', name: 'gistsrc', label: 'Gist URL' },
                    {type: 'textbox', name: 'gistheight', label: 'Height' }
                ],
                onsubmit: function(e) {
                  if (e.data.gistsrc !== null) {
                    var test = e.data.gistsrc.indexOf('https://gist.github.com/');
                    if (test == 0) {
                      shortcode = '[gist src="' + e.data.gistsrc + '" height="' + e.data.gistheight + '"]';
                      ed.execCommand('mceInsertContent', 0, shortcode);
                    } else {
                      alert("That doesn't look like a Gist src.");
                    }
                  }
                }
              });
            });
        },
 
        /**
         * Creates control instances based in the incoming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Embed Gist',
                author : 'James Robinson',
                authorurl : 'https://imaginarymedia.com.au/',
                infourl : 'https://imaginarymedia.com.au/projects/enbed-gists/',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'embedgist', tinymce.plugins.embedgist );
})();