(function() {
    var template_uri = object_name.template_uri;

    tinymce.create('tinymce.plugins.shortcode_buttons', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */


         init : function(ed, url) {
         	ed.addButton('panel', {
         		title : 'Add Panel', 
         		image : template_uri + '/images/TinyMCE/panel.png',
         		onclick : function() {
         			ed.selection.setContent('[panel type="text_only"]' + ed.selection.getContent() + '[/panel]');
         		}
         	});

            ed.addButton('button', {
                title : 'Add Button', 
                image : template_uri + '/images/TinyMCE/button.png',
                onclick : function() {
                    ed.selection.setContent('[button href="" target="_blank"]' + ed.selection.getContent() + '[/button]');
                }
            });

            ed.addButton('excerpts', {
                title : 'Add Excerpts', 
                image : template_uri + '/images/TinyMCE/excerpts.png',
                onclick : function() {
                    ed.selection.setContent('[excerpts display="3"]');
                }
            });

            ed.addButton('column_halfs', {
                title : '2 Columns 1:1', 
                image : template_uri + '/images/TinyMCE/column_halfs.png',
                onclick : function() {
                    ed.selection.setContent('[one_half] First Column [/one_half] [one_half_last] Second Column [/one_half_last]');
                }
            });

            ed.addButton('column_thirds', {
                title : '3 Columns 1:1:1', 
                image : template_uri + '/images/TinyMCE/column_thirds.png',
                onclick : function() {
                    ed.selection.setContent('[one_third] First Column [/one_third] [one_third] Second Column [/one_third] [one_third_last] Third Column [/one_third_last]');
                }
            });
         },


        createControl : function(n, cm) {
            return null;
        },

    });

    // Register plugin
    tinymce.PluginManager.add('panel', tinymce.plugins.shortcode_buttons);
    tinymce.PluginManager.add('button', tinymce.plugins.shortcode_buttons);
    tinymce.PluginManager.add('excerpts', tinymce.plugins.shortcode_buttons);
    tinymce.PluginManager.add('column_halfs', tinymce.plugins.shortcode_buttons);
    tinymce.PluginManager.add('column_thirds', tinymce.plugins.shortcode_buttons);
})();