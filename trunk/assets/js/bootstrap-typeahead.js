/* =============================================================
 * bootstrap-typeahead.js v2.0.2
 * http://twitter.github.com/bootstrap/javascript.html#typeahead
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */
/*
 *contoh penggunaan
 *=================
 *$('#tab-serviceSheet #nip').typeahead({
        url : site_url+"master/peminjam/suggestion",  ---> url
        objCatch : 'nip_options', -----> object utama yang akan diambil hasilnya
        dataToView : { --->object object yang diambil untuk di view di beberapa form field lain
            peminjam_options : '#customer',
            jabatan_options : '#jabatan'
        }
    });
 */

!function( $ ){

    "use strict"

    var Typeahead = function ( element, options ) {
        this.$element = $(element)
        this.options = $.extend({}, $.fn.typeahead.defaults, options)
        this.matcher = this.options.matcher || this.matcher
        this.sorter = this.options.sorter || this.sorter
        this.highlighter = this.options.highlighter || this.highlighter
        this.$menu = $(this.options.menu).appendTo('body')
        this.source = this.options.source
        this.shown = false
        this.listen()
    
        //modified by yudi  
        /*
         *objCatch, bisa dilihat di tab firebug JSON, dan di array model database di CI
         *dataToView_res_inline, artinya bila data hasil dataToView di keluarkan sebaris
         *qWhere ---> harus valuenya langsung, where statement , harusnya bisa dicampur dengan elem_NAME ( kueri where utama )
         *parseData, ini merupakan where custom yang dapat diambil dari nama elemen, ini bisa menggangikan elem_NAME
         *hidesome, untuk hide sesuatu jika dibutuhkan, dengan format false|elementHTML
         */
        this.url = this.options.url
        this.objCatch = this.options.objCatch
        this.parseData = this.options.parseData
        this.qWhere = this.options.qWhere
        this.dataToView = this.options.dataToView
        this.dataToView_res_inline = this.options.dataToView_res_inline
        this.integration = this.options.integration
        this.hidesome = this.options.hidesome
        this.callback_fn = this.options.callback_fn
        this
        $.res_suggestion = {};
        
    }
        
    Typeahead.prototype = {

        constructor: Typeahead

        , 
        select: function () {
            var val = this.$menu.find('.active').attr('data-value')
            this.$element.val(val)
            //data to view, ke inputan2 yang diinginkan
            
            //kalo dataToView_res_inline di set true
            if(this.dataToView_res_inline == true ){
                //get current index line nya
                var curr_elem = this.$element.attr('name');
                var line_idx = $('input[name="'+curr_elem+'"]').index(this.$element);
            }
            var dataToView_res_inline = this.dataToView_res_inline;
            if(typeof(this.dataToView) == "object"){//defined dan ada isinya
                var res_obj = $.res_obj;
                $.each(this.dataToView, function(jsonObj,elemID){
                    if(dataToView_res_inline == true ){ 
                        if($(elemID).is('INPUT'))
                            $(elemID+':eq('+line_idx+')').val((res_obj[jsonObj][val] == '')?'':res_obj[jsonObj][val]);
                        else
                            $(elemID+':eq('+line_idx+')').text((res_obj[jsonObj][val] == '')?'':res_obj[jsonObj][val]);
                        
                    }
                    else{
                        if($(elemID).is('INPUT'))
                            $(elemID).val((res_obj[jsonObj][val] == '')?'':res_obj[jsonObj][val]);
                        else
                            $(elemID).text((res_obj[jsonObj][val] == '')?'':res_obj[jsonObj][val]);
                    }
                });
            }
            //END
       
            //do a function if success
            if(this.callback_fn){
                this.callback_fn();
            }
            //END
       
            this.$element.change();
            return this.hide()
        }


        , 
        show: function () {
            var pos = $.extend({}, this.$element.offset(), {
                height: this.$element[0].offsetHeight
            })

            this.$menu.css({
                top: pos.top + pos.height
                , 
                left: pos.left
            })

            this.$menu.show()
            this.shown = true
            return this
        }
        , 
        hide: function () {
            this.$menu.hide()
            this.shown = false
            return this
        }
        , 
        lookup: function (event) {
            
            var that = this
            , items
            , q
            this.query = this.$element.val();
            if (!this.query) {
                return this.shown ? this.hide() : this
            }
            //modified by yudi@022412
            var elem_NAME = this.$element.attr('name');
            var q_key = this.query;
            var objCatch = this.objCatch;
            var q_string = {};//harus object, ini bisa dimasukkan dengan cara array
            q_string[elem_NAME] = q_key;
            q_string[this.parseData] = q_key;//jika nama INPUT tidak sama dengan nama field di table
            if(this.qWhere){
                $.map( this.qWhere, function( n,i ) {
                    return q_string[i] = n;
                });
            }
            
            //check useas400 or not
            var integration = this.integration;
            if(integration){ 
                //get current index line nya
                var curr_elem = this.$element.attr('name');
                var line_idx = $('input[name="'+curr_elem+'"]').index(this.$element);
                
                if(integration.source === 'as400'){
                    var indicator_checked = integration.indicator_checked;
                    var is_checked = ($('input[name="'+indicator_checked+'[]"]:eq('+line_idx+'):checked').length > 0 )?true:false;
                    q_string[integration.source] = (is_checked === true)?$('input[name="'+indicator_checked+'[]"]:eq('+line_idx+')').val():0;
                }else{ 
                    var indicator_checked = integration.indicator_checked;
                    q_string[integration.source] = $('select[name^="'+indicator_checked+'"]:eq('+line_idx+')').val();
                }
                
            }
            var url_json = this.url;
            var $this = this;
            $.ajax({
                type: "GET",
                url: url_json,
                dataType:"json",
                data: q_string,
                success: function(res, textStatus, jqXHR){ 
                    
                    if(res != null){
                        //hide some elem
                        if($this.hidesome){
                            //extract multiple hide elements
                            var hidesome_multiple = $this.hidesome.split('^');
                            $.each(hidesome_multiple,function(i,hidesome_single_raw){
                                var hidesome_single = hidesome_single_raw.split('|');
                                var hidesome_single_condition = hidesome_single[0] == 'true'?true:false;
                                var hidesome_single_elem = hidesome_single[1];
                                if(hidesome_single_condition == true )$(hidesome_single_elem).hide();
                                else $(hidesome_single_elem).show();
                            });
                        }
                        $.res_obj = res;
                        var res_suggestion = $.map( res[objCatch], function( value ) { 
                            return value;
                        });
                        items = $.grep(res_suggestion, function (item) {
                            if (that.matcher(item)) return item
                        })
                        
                        items = $this.sorter(items);

                        if (!items.length) {
                            return $this.shown ? $this.hide() : $this
                        }

                        return $this.render(items.slice(0, $this.options.items)).show();
                    }else{
                        if($this.hidesome){ 
                            //extract multiple hide elements
                            var hidesome_multiple = $this.hidesome.split('^');
                            $.each(hidesome_multiple,function(i,hidesome_single_raw){
                                var hidesome_single = hidesome_single_raw.split('|');
                                var hidesome_single_elem = hidesome_single[1];
                                $(hidesome_single_elem).show();
                            });
                        }
                        return $this.hide();
                    }
                    
                }
            });
        }
        , 
        matcher: function (item) {
            return ~item.toLowerCase().indexOf(this.query.toLowerCase())
        }


        , 
        sorter: function (items) {
            var beginswith = []
            , caseSensitive = []
            , caseInsensitive = []
            , item

            while (item = items.shift()) {
                if (!item.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(item)
                else if (~item.indexOf(this.query)) caseSensitive.push(item)
                else caseInsensitive.push(item)
            }

            return beginswith.concat(caseSensitive, caseInsensitive)
        }

        , 
        highlighter: function (item) {
            return item.replace(new RegExp('(' + this.query + ')', 'ig'), function ($1, match) {
                return '<strong>' + match + '</strong>'
            })
        }

        , 
        render: function (items) {
            var that = this
            items = $(items).map(function (i, item) {
                i = $(that.options.item).attr('data-value', item)
                i.find('a').html(that.highlighter(item))
                return i[0]
            })
            items.first().addClass('active')
            this.$menu.html(items)
            return this
        }

        , 
        next: function (event) {
            var active = this.$menu.find('.active').removeClass('active')
            , next = active.next()

            if (!next.length) {
                next = $(this.$menu.find('li')[0])
            }



            next.addClass('active')
        }

        , 
        prev: function (event) {
            var active = this.$menu.find('.active').removeClass('active')
            , prev = active.prev()

            if (!prev.length) {
                prev = this.$menu.find('li').last()
            }

            prev.addClass('active')
        }

        , 
        listen: function () {
            this.$element
            .on('blur',     $.proxy(this.blur, this))
            .on('keypress', $.proxy(this.keypress, this))
            .on('keyup',    $.proxy(this.keyup, this))

            if ($.browser.webkit || $.browser.msie) {
                this.$element.on('keydown', $.proxy(this.keypress, this))
            }

            this.$menu
            .on('click', $.proxy(this.click, this))
            .on('mouseenter', 'li', $.proxy(this.mouseenter, this))
        }

        , 
        keyup: function (e) {
            switch(e.keyCode) {
                case 40: // down arrow
                case 38: // up arrow
                    break

                case 9: // tab
                case 13: // enter
                    if (!this.shown) return
                    this.select()
                    break

                case 27: // escape
                    if (!this.shown) return
                    this.hide()
                    break

                default:
                    this.lookup();
            }


            e.stopPropagation()
            e.preventDefault()
        }



        , 
        keypress: function (e) {
            if (!this.shown) return

            switch(e.keyCode) {
                case 9: // tab
                case 13: // enter
                case 27: // escape
                    e.preventDefault()
                    break

                case 38: // up arrow
                    e.preventDefault()
                    this.prev()
                    break

                case 40: // down arrow
                    e.preventDefault()
                    this.next()
                    break
            }



            e.stopPropagation()
        }


        , 
        blur: function (e) {
            var that = this
            setTimeout(function () {
                that.hide()
            }, 150)
        }


        , 
        click: function (e) {
            e.stopPropagation()
            e.preventDefault()
            this.select()
        }

        , 
        mouseenter: function (e) {
            this.$menu.find('.active').removeClass('active')
            $(e.currentTarget).addClass('active')
        }

    }



    /* TYPEAHEAD PLUGIN DEFINITION
     * =========================== */


    $.fn.typeahead = function ( option ) {
        return this.each(function () {
            var $this = $(this)
            , data = $this.data('typeahead')
            , options = typeof option == 'object' && option
            if (!data) $this.data('typeahead', (data = new Typeahead(this, options)))
            if (typeof option == 'string') data[option]()
        })
    }

    $.fn.typeahead.defaults = {
        source: []
        , 
        items: 8
        , 
        menu: '<ul class="typeahead dropdown-menu"></ul>'
        , 
        item: '<li><a href="#"></a></li>'
    }

    $.fn.typeahead.Constructor = Typeahead




    /* TYPEAHEAD DATA-API
     * ================== */

    $(function () {
        $('body').on('focus.typeahead.data-api', '[data-provide="typeahead"]', function (e) {
            var $this = $(this)
            if ($this.data('typeahead')) return
            e.preventDefault()
            $this.typeahead($this.data())
        })
    })

}( window.jQuery );