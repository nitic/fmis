/*
 * jQuery teegrid Plugin 0.2.0
 * https://github.com/maxazan/jquery-teegrid
 * 
 * Copyright 2013, Pomazan Max
 * Licensed under the MIT licenses.
 */
(function($) {

    var methods = {
        /**
         * Initialize tree
         * 
         * @param {Object} options
         * @returns {Object[]}
         */
        initTree: function(options) {
            var settings = $.extend({}, this.teegrid.defaults, options);
            return this.each(function() {
                var $this = $(this);
                $this.teegrid('setTreeContainer', $(this));
                $this.teegrid('setSettings', settings);
                settings.getRootNodes.apply(this, [$(this)]).teegrid('initNode', settings);
            });
        },
        /**
         * Initialize node
         * 
         * @param {Object} settings
         * @returns {Object[]}
         */
        initNode: function(settings) {
            return this.each(function() {
                var $this = $(this);
                $this.teegrid('setTreeContainer', settings.getteegridContainer.apply(this));
                $this.teegrid('getChildNodes').teegrid('initNode', settings);
                $this.teegrid('initExpander').teegrid('initIndent').teegrid('initEvents').teegrid('initState').teegrid("initSettingsEvents");
            });
        },
        /**
         * Initialize node events
         * 
         * @returns {Node}
         */
        initEvents: function() {
            var $this = $(this);
            //Save state on change
            $this.on("change", function() {
                var $this = $(this);
                $this.teegrid('render');
                if ($this.teegrid('getSetting', 'saveState')) {
                    $this.teegrid('saveState');
                }
            });
            //Default behavior on collapse
            $this.on("collapse", function() {
                var $this = $(this);
                $this.removeClass('teegrid-expanded');
                $this.addClass('teegrid-collapsed');
            });
            //Default behavior on expand
            $this.on("expand", function() {
                var $this = $(this);
                $this.removeClass('teegrid-collapsed');
                $this.addClass('teegrid-expanded');
            });

            return $this;
        },
        /**
         * Initialize events from settings
         * 
         * @returns {Node}
         */
        initSettingsEvents: function() {
            var $this = $(this);
            //Save state on change
            $this.on("change", function() {
                var $this = $(this);
                if (typeof ($this.teegrid('getSetting', 'onChange')) === "function") {
                    $this.teegrid('getSetting', 'onChange').apply($this);
                }
            });
            //Default behavior on collapse
            $this.on("collapse", function() {
                var $this = $(this);
                if (typeof ($this.teegrid('getSetting', 'onCollapse')) === "function") {
                    $this.teegrid('getSetting', 'onCollapse').apply($this);
                }
            });
            //Default behavior on expand
            $this.on("expand", function() {
                var $this = $(this);
                if (typeof ($this.teegrid('getSetting', 'onExpand')) === "function") {
                    $this.teegrid('getSetting', 'onExpand').apply($this);
                }

            });

            return $this;
        },
        /**
         * Initialize expander for node
         * 
         * @returns {Node}
         */
        initExpander: function() {
            var $this = $(this);
            var cell = $this.find('td').get($this.teegrid('getSetting', 'treeColumn'));
            var tpl = $this.teegrid('getSetting', 'expanderTemplate');
            var expander = $this.teegrid('getSetting', 'getExpander').apply(this);
            if (expander) {
                expander.remove();
            }
            $(tpl).prependTo(cell).click(function() {
                $($(this).closest('tr')).teegrid('toggle');
            });
            return $this;
        },
        /**
         * Initialize indent for node
         * 
         * @returns {Node}
         */
        initIndent: function() {
            var $this = $(this);
            $this.find('.teegrid-indent').remove();
            for (var i = 0; i < $(this).teegrid('getDepth'); i++) {
                $($this.teegrid('getSetting', 'indentTemplate')).insertBefore($this.find('.teegrid-expander'));
            }
            return $this;
        },
        /**
         * Initialise state of node
         * 
         * @returns {Node}
         */
        initState: function() {
            var $this = $(this);
            if ($this.teegrid('getSetting', 'saveState') && !$this.teegrid('isFirstInit')) {
                $this.teegrid('restoreState');
            } else {
                if ($this.teegrid('getSetting', 'initialState') === "expanded") {
                    $this.teegrid('expand');
                } else {
                    $this.teegrid('collapse');
                }
            }
            return $this;
        },
        /**
         * Return true if this tree was never been initialised
         * 
         * @returns {Boolean}
         */
        isFirstInit: function() {
            var tree = $(this).teegrid('getTreeContainer');
            if (tree.data('first_init') === undefined) {
                tree.data('first_init', $.cookie(tree.teegrid('getSetting', 'saveStateName')) === undefined);
            }
            return tree.data('first_init');
        },
        /**
         * Save state of current node
         * 
         * @returns {Node}
         */
        saveState: function() {
            var $this = $(this);
            if ($this.teegrid('getSetting', 'saveStateMethod') === 'cookie') {

                var stateArrayString = $.cookie($this.teegrid('getSetting', 'saveStateName')) || '';
                var stateArray = (stateArrayString === '' ? [] : stateArrayString.split(','));
                var nodeId = $this.teegrid('getNodeId');

                if ($this.teegrid('isExpanded')) {
                    if ($.inArray(nodeId, stateArray) === -1) {
                        stateArray.push(nodeId);
                    }
                } else if ($this.teegrid('isCollapsed')) {
                    if ($.inArray(nodeId, stateArray) !== -1) {
                        stateArray.splice($.inArray(nodeId, stateArray), 1);
                    }
                }
                $.cookie($this.teegrid('getSetting', 'saveStateName'), stateArray.join(','));
            }
            return $this;
        },
        /**
         * Restore state of current node.
         * 
         * @returns {Node}
         */
        restoreState: function() {
            var $this = $(this);
            if ($this.teegrid('getSetting', 'saveStateMethod') === 'cookie') {
                var stateArray = $.cookie($this.teegrid('getSetting', 'saveStateName')).split(',');
                if ($.inArray($this.teegrid('getNodeId'), stateArray) !== -1) {
                    $this.teegrid('expand');
                } else {
                    $this.teegrid('collapse');
                }

            }
            return $this;
        },
        /**
         * Method return setting by name
         * 
         * @param {type} name
         * @returns {unresolved}
         */
        getSetting: function(name) {
            if (!$(this).teegrid('getTreeContainer')) {
                return null;
            }
            return $(this).teegrid('getTreeContainer').data('settings')[name];
        },
        /**
         * Add new settings
         * 
         * @param {Object} settings
         */
        setSettings: function(settings) {
            $(this).teegrid('getTreeContainer').data('settings', settings);
        },
        /**
         * Return tree container
         * 
         * @returns {HtmlElement}
         */
        getTreeContainer: function() {
            return $(this).data('teegrid');
        },
        /**
         * Set tree container
         * 
         * @param {HtmlE;ement} container
         */
        setTreeContainer: function(container) {
            return $(this).data('teegrid', container);
        },
        /**
         * Method return all root nodes of tree. 
         * 
         * Start init all child nodes from it.
         * 
         * @returns {Array}
         */
        getRootNodes: function() {
            return $(this).teegrid('getSetting', 'getRootNodes').apply(this, [$(this).teegrid('getTreeContainer')]);
        },
        /**
         * Method return all nodes of tree. 
         * 
         * @returns {Array}
         */
        getAllNodes: function() {
            return $(this).teegrid('getSetting', 'getAllNodes').apply(this, [$(this).teegrid('getTreeContainer')]);
        },
        /**
         * Mthod return true if element is Node
         * 
         * @returns {String}
         */
        isNode: function() {
            return $(this).teegrid('getNodeId') !== null;
        },
        /**
         * Mthod return id of node
         * 
         * @returns {String}
         */
        getNodeId: function() {
            if ($(this).teegrid('getSetting', 'getNodeId') === null) {
                return null;
            } else {
                return $(this).teegrid('getSetting', 'getNodeId').apply(this);
            }
        },
        /**
         * Method return parent id of node or null if root node
         * 
         * @returns {String}
         */
        getParentNodeId: function() {
            return $(this).teegrid('getSetting', 'getParentNodeId').apply(this);
        },
        /**
         * Method return parent node or null if root node
         * 
         * @returns {Object[]}
         */
        getParentNode: function() {
            if ($(this).teegrid('getParentNodeId') === null) {
                return null;
            } else {
                return $(this).teegrid('getSetting', 'getNodeById').apply(this, [$(this).teegrid('getParentNodeId'), $(this).teegrid('getTreeContainer')]);
            }
        },
        /**
         * Method return array of child nodes or null if node is leaf
         * 
         * @returns {Object[]}
         */
        getChildNodes: function() {
            return $(this).teegrid('getSetting', 'getChildNodes').apply(this, [$(this).teegrid('getNodeId'), $(this).teegrid('getTreeContainer')]);
        },
        /**
         * Method return depth of tree.
         * 
         * This method is needs for calculate indent
         * 
         * @returns {Number}
         */
        getDepth: function() {
            if ($(this).teegrid('getParentNode') === null) {
                return 0;
            }
            return $(this).teegrid('getParentNode').teegrid('getDepth') + 1;
        },
        /**
         * Method return true if node is root
         * 
         * @returns {Boolean}
         */
        isRoot: function() {
            return $(this).teegrid('getDepth') === 0;
        },
        /**
         * Method return true if node has no child nodes
         * 
         * @returns {Boolean}
         */
        isLeaf: function() {
            return $(this).teegrid('getChildNodes').length === 0;
        },
        /**
         * Method return true if node last in branch
         * 
         * @returns {Boolean}
         */
        isLast: function() {
            if ($(this).teegrid('isNode')) {
                var parentNode = $(this).teegrid('getParentNode');
                if (parentNode === null) {
                    if ($(this).teegrid('getNodeId') === $(this).teegrid('getRootNodes').last().teegrid('getNodeId')) {
                        return true;
                    }
                } else {
                    if ($(this).teegrid('getNodeId') === parentNode.teegrid('getChildNodes').last().teegrid('getNodeId')) {
                        return true;
                    }
                }
            }
            return false;
        },
        /**
         * Method return true if node first in branch
         * 
         * @returns {Boolean}
         */
        isFirst: function() {
            if ($(this).teegrid('isNode')) {
                var parentNode = $(this).teegrid('getParentNode');
                if (parentNode === null) {
                    if ($(this).teegrid('getNodeId') === $(this).teegrid('getRootNodes').first().teegrid('getNodeId')) {
                        return true;
                    }
                } else {
                    if ($(this).teegrid('getNodeId') === parentNode.teegrid('getChildNodes').first().teegrid('getNodeId')) {
                        return true;
                    }
                }
            }
            return false;
        },
        /**
         * Return true if node expanded
         * 
         * @returns {Boolean}
         */
        isExpanded: function() {
            return $(this).hasClass('teegrid-expanded');
        },
        /**
         * Return true if node collapsed
         * 
         * @returns {Boolean}
         */
        isCollapsed: function() {
            return $(this).hasClass('teegrid-collapsed');
        },
        /**
         * Return true if at least one of parent node is collapsed
         * 
         * @returns {Boolean}
         */
        isOneOfParentsCollapsed: function() {
            var $this = $(this);
            if ($this.teegrid('isRoot')) {
                return false;
            } else {
                if ($this.teegrid('getParentNode').teegrid('isCollapsed')) {
                    return true;
                } else {
                    return $this.teegrid('getParentNode').teegrid('isOneOfParentsCollapsed');
                }
            }
        },
        /**
         * Expand node
         * 
         * @returns {Node}
         */
        expand: function() {
            return $(this).each(function() {
                var $this = $(this);
                if (!$this.teegrid('isLeaf') && !$this.teegrid("isExpanded")) {
                    $this.trigger("expand");
                    $this.trigger("change");
                }
            });
        },
        /**
         * Expand all nodes
         * 
         * @returns {Node}
         */
        expandAll: function() {
            var $this = $(this);
            $this.teegrid('getRootNodes').teegrid('expandRecursive');
            return $this;
        },
        /**
         * Expand current node and all child nodes begin from current
         * 
         * @returns {Node}
         */
        expandRecursive: function() {
            return $(this).each(function() {
                var $this = $(this);
                $this.teegrid('expand');
                if (!$this.teegrid('isLeaf')) {
                    $this.teegrid('getChildNodes').teegrid('expandRecursive');
                }
            });
        },
        /**
         * Collapse node
         * 
         * @returns {Node}
         */
        collapse: function() {
            return $(this).each(function() {
                var $this = $(this);
                if (!$this.teegrid('isLeaf') && !$this.teegrid("isCollapsed")) {
                    $this.trigger("collapse");
                    $this.trigger("change");
                }
            });
        },
        /**
         * Collapse all nodes
         * 
         * @returns {Node}
         */
        collapseAll: function() {
            var $this = $(this);
            $this.teegrid('getRootNodes').teegrid('collapseRecursive');
            return $this;
        },
        /**
         * Collapse current node and all child nodes begin from current
         * 
         * @returns {Node}
         */
        collapseRecursive: function() {
            return $(this).each(function() {
                var $this = $(this);
                $this.teegrid('collapse');
                if (!$this.teegrid('isLeaf')) {
                    $this.teegrid('getChildNodes').teegrid('collapseRecursive');
                }
            });
        },
        /**
         * Expand if collapsed, Collapse if expanded
         * 
         * @returns {Node}
         */
        toggle: function() {
            var $this = $(this);
            if ($this.teegrid('isExpanded')) {
                $this.teegrid('collapse');
            } else {
                $this.teegrid('expand');
            }
            return $this;
        },
        /**
         * Rendering node
         * 
         * @returns {Node}
         */
        render: function() {
            return $(this).each(function() {
                var $this = $(this);

                if ($this.teegrid('isOneOfParentsCollapsed')) {
                    $this.hide();
                } else {
                    $this.show();
                }
                if (!$this.teegrid('isLeaf')) {
                    $this.teegrid('renderExpander');
                    $this.teegrid('getChildNodes').teegrid('render');
                }
            });
        },
        /**
         * Rendering expander depends on node state
         * 
         * @returns {Node}
         */
        renderExpander: function() {
            return $(this).each(function() {
                var $this = $(this);
                var expander = $this.teegrid('getSetting', 'getExpander').apply(this);
                if (expander) {

                    if (!$this.teegrid('isCollapsed')) {
                        expander.removeClass($this.teegrid('getSetting', 'expanderCollapsedClass'));
                        expander.addClass($this.teegrid('getSetting', 'expanderExpandedClass'));
                    } else {
                        expander.removeClass($this.teegrid('getSetting', 'expanderExpandedClass'));
                        expander.addClass($this.teegrid('getSetting', 'expanderCollapsedClass'));
                    }
                } else {
                    $this.teegrid('initExpander');
                    $this.teegrid('renderExpander');
                }
            });
        }
    };
    $.fn.teegrid = function(method) {
        if (methods[method]) {
            return methods[ method ].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.initTree.apply(this, arguments);
        } else {
            $.error('Method with name ' + method + ' does not exists for jQuery.teegrid');
        }
    };
    /**
     *  Plugin's default options
     */
    $.fn.teegrid.defaults = {
        initialState: 'expanded',
        saveState: false,
        saveStateMethod: 'cookie',
        saveStateName: 'tree-grid-state',
        expanderTemplate: '<span class="teegrid-expander"></span>',
        indentTemplate: '<span class="teegrid-indent"></span>',
        expanderExpandedClass: 'teegrid-expander-expanded',
        expanderCollapsedClass: 'teegrid-expander-collapsed',
        treeColumn: 0,
        getExpander: function() {
            return $(this).find('.teegrid-expander');
        },
        getNodeId: function() {
            var template = /teegrid-([A-Za-z0-9_-]+)/;
            if (template.test($(this).attr('class'))) {
                return template.exec($(this).attr('class'))[1];
            }
            return null;
        },
        getParentNodeId: function() {
            var template = /teegrid-parent-([A-Za-z0-9_-]+)/;
            if (template.test($(this).attr('class'))) {
                return template.exec($(this).attr('class'))[1];
            }
            return null;
        },
        getNodeById: function(id, teegridContainer) {
            var templateClass = "teegrid-" + id;
            return teegridContainer.find('tr.' + templateClass);
        },
        getChildNodes: function(id, teegridContainer) {
            var templateClass = "teegrid-parent-" + id;
            return teegridContainer.find('tr.' + templateClass);
        },
        getteegridContainer: function() {
            return $(this).closest('table');
        },
        getRootNodes: function(teegridContainer) {
            var result = $.grep(teegridContainer.find('tr'), function(element) {
                var classNames = $(element).attr('class');
                var templateClass = /teegrid-([A-Za-z0-9_-]+)/;
                var templateParentClass = /teegrid-parent-([A-Za-z0-9_-]+)/;
                return templateClass.test(classNames) && !templateParentClass.test(classNames);
            });
            return $(result);
        },
        getAllNodes: function(teegridContainer) {
            var result = $.grep(teegridContainer.find('tr'), function(element) {
                var classNames = $(element).attr('class');
                var templateClass = /teegrid-([A-Za-z0-9_-]+)/;
                return templateClass.test(classNames);
            });
            return $(result);
        },
        //Events
        onCollapse: null,
        onExpand: null,
        onChange: null

    };
})(jQuery);