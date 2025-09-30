// Ajax
    jQuery.each(["put", "delete"], function (i, method) {
        jQuery[ method ] = function (url, data, callback, type) {
            if (jQuery.isFunction(data)) {
                type = type || callback;
                callback = data;
                data = undefined;
            }

            return jQuery.ajax({
                url: url,
                type: method,
                dataType: type,
                data: data,
                success: callback
            });
        };
    });


// Is Int and Float
    function isInt(n){
        return Number(n) === n && n % 1 === 0;
    }

    function isFloat(n){
        return Number(n) === n && n % 1 !== 0;
    }

    function convertNumber(n){
        return  n && Number(n) === parseFloat(n) ? parseFloat(n) : 0;
    }


// formatMoney - Number
    Number.prototype.formatMoney = function(c, d, t){
        var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };


// format - Date
    Date.prototype.format = function(e){
        var t="";var n=Date.replaceChars;for(var r=0;r<e.length;r++){var i=e.charAt(r);if(r-1>=0&&e.charAt(r-1)=="\\"){t+=i}else if(n[i]){t+=n[i].call(this)}else if(i!="\\"){t+=i}}return t};Date.replaceChars={shortMonths:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],longMonths:["January","February","March","April","May","June","July","August","September","October","November","December"],shortDays:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],longDays:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],d:function(){return(this.getDate()<10?"0":"")+this.getDate()},D:function(){return Date.replaceChars.shortDays[this.getDay()]},j:function(){return this.getDate()},l:function(){return Date.replaceChars.longDays[this.getDay()]},N:function(){return this.getDay()+1},S:function(){return this.getDate()%10==1&&this.getDate()!=11?"st":this.getDate()%10==2&&this.getDate()!=12?"nd":this.getDate()%10==3&&this.getDate()!=13?"rd":"th"},w:function(){return this.getDay()},z:function(){var e=new Date(this.getFullYear(),0,1);return Math.ceil((this-e)/864e5)},W:function(){var e=new Date(this.getFullYear(),0,1);return Math.ceil(((this-e)/864e5+e.getDay()+1)/7)},F:function(){return Date.replaceChars.longMonths[this.getMonth()]},m:function(){return(this.getMonth()<9?"0":"")+(this.getMonth()+1)},M:function(){return Date.replaceChars.shortMonths[this.getMonth()]},n:function(){return this.getMonth()+1},t:function(){var e=new Date;return(new Date(e.getFullYear(),e.getMonth(),0)).getDate()},L:function(){var e=this.getFullYear();return e%400==0||e%100!=0&&e%4==0},o:function(){var e=new Date(this.valueOf());e.setDate(e.getDate()-(this.getDay()+6)%7+3);return e.getFullYear()},Y:function(){return this.getFullYear()},y:function(){return(""+this.getFullYear()).substr(2)},a:function(){return this.getHours()<12?"am":"pm"},A:function(){return this.getHours()<12?"AM":"PM"},B:function(){return Math.floor(((this.getUTCHours()+1)%24+this.getUTCMinutes()/60+this.getUTCSeconds()/3600)*1e3/24)},g:function(){return this.getHours()%12||12},G:function(){return this.getHours()},h:function(){return((this.getHours()%12||12)<10?"0":"")+(this.getHours()%12||12)},H:function(){return(this.getHours()<10?"0":"")+this.getHours()},i:function(){return(this.getMinutes()<10?"0":"")+this.getMinutes()},s:function(){return(this.getSeconds()<10?"0":"")+this.getSeconds()},u:function(){var e=this.getMilliseconds();return(e<10?"00":e<100?"0":"")+e},e:function(){return"Not Yet Supported"},I:function(){var e=null;for(var t=0;t<12;++t){var n=new Date(this.getFullYear(),t,1);var r=n.getTimezoneOffset();if(e===null)e=r;else if(r<e){e=r;break}else if(r>e)break}return this.getTimezoneOffset()==e|0},O:function(){return(-this.getTimezoneOffset()<0?"-":"+")+(Math.abs(this.getTimezoneOffset()/60)<10?"0":"")+Math.abs(this.getTimezoneOffset()/60)+"00"},P:function(){return(-this.getTimezoneOffset()<0?"-":"+")+(Math.abs(this.getTimezoneOffset()/60)<10?"0":"")+Math.abs(this.getTimezoneOffset()/60)+":00"},T:function(){var e=this.getMonth();this.setMonth(0);var t=this.toTimeString().replace(/^.+ \(?([^\)]+)\)?$/,"$1");this.setMonth(e);return t},Z:function(){return-this.getTimezoneOffset()*60},c:function(){return this.format("Y-m-d\\TH:i:sP")},r:function(){return this.toString()},U:function(){return this.getTime()/1e3}
    }


// Obtener Edad
    var getEdad = function(string) {
        return ((Date.now() / 1000) - (new Date(string).getTime() / 1000)) / (365 * 24 * 60 * 60);
    }


// HTML Rating
    var html_rating = function(value, size){
        switch(value){
            case 1: rating = ''; break;
            case 2: rating = ''; break;
            case 3: rating = ''; break;
            case 4: rating = ''; break;
            case 5: rating = ''; break;
            default: rating = ''; break;
        }

        return '<div data-content="" class="rating-container rating-gly-star"><div style="width: 100%;" data-content="' + rating + '" class="rating-stars"></div></div>';
    }


// Estado del Servidor
    var nifty_avg = function(avg_url, avg_interval){
        avg_load_html(avg_url);

        setInterval(function(){
            avg_load_html(avg_url);

        }, avg_interval);
    };

    var avg_load_html = function(avg_url){
        var $wg_server = $('#wg-server'),
            elem = {
                $label_cpu_use    : $('.label-cpu-use', $wg_server),
                $progress_bar_cpu : $('.progress-bar-cpu', $wg_server),
                $label_mem_use    : $('.label-mem-use', $wg_server),
                $progress_bar_mem : $('.progress-bar-mem', $wg_server),
            };

        $.get(avg_url + '/avg_load.php', function(json){
            elem.$label_cpu_use.html(json.cpu + '%');
            elem.$progress_bar_cpu.css('width', json.cpu + '%');
            elem.$label_mem_use.html(json.mem + '%');
            elem.$progress_bar_mem.css('width', json.mem + '%');
        }, 'json');
    };

// BootstrapTable - Get height
    var getBttHeight = function() {
        var contents_height = $('.navbar').outerHeight() + $('#page-title').outerHeight() + $('.breadcrumb').outerHeight() + $('#footer').outerHeight(),
            //bt_table_height = $(window).height() - contents_height - 20,
            bt_table_height = $(window).height(),
            bt_table_height = bt_table_height < 500? 750 : bt_table_height;

        return bt_table_height;
    }


// BootstrapTable - Resize height
    var resizeBootstrapTable = function($btt) {
        $btt.bootstrapTable('resetView', {'height':getBttHeight()});
    }

// My BootstrapTable Builder
    function MyBttBuilder(params) {
        var plugin   = this;

        plugin.toolbar         = params.element + ' .btt-toolbar';
        plugin.$filters        = $(params.element + ' .btt-toolbar :input, .filter-top :input');
        plugin.url             = params.url;
        plugin.colorCompra      = params.colorCompra ? true : false;
        plugin.autoHeight      = params.autoHeight;
        plugin.$bootstrapTable = $(params.element + ' .bootstrap-table');

        bootstrapTableParamsDefault = {
            search      : true,
            showRefresh : true,
            showColumns : true,
            showToggle  : true,
            pagination  : true,
            icons: {
              paginationSwitchDown: 'fa-caret-square-o-down',
              paginationSwitchUp: 'fa-caret-square-o-up',
              refresh: 'fa-refresh',
              toggleOff: 'fa-toggle-off',
              toggleOn: 'fa-toggle-on',
              columns: 'fa-th-list',
              detailOpen: 'fa-plus',
              detailClose: 'fa-minus',
              fullscreen: 'fa-arrows-alt',
              search: 'fa-search',
              export: 'fa fa-download',
              clearSearch: 'fa-trash'
            },
            sidePagination : 'server',
            showPaginationSwitch : true,
            pageList    : [50, 100, 500, 1000, 2000, 5000, 10000],
            pageSize    : 100,
            sortName    : 'id',
            sortOrder   : 'desc',

            showExport       : true,
            exportTypes      : ['excel', 'csv', 'xml'],
            mobileResponsive : true,
            cookie           : true,
            resizable        : true,
            cookieIdTable    : 'ES-bootstrap-table-' + params.id,
            toolbar          : plugin.toolbar,
            queryParams : function(params){
                params['filters'] = plugin.$filters.serialize();

                return params;
            },
            onLoadSuccess : function(row, $element){
                if(plugin.autoHeight !== false)
                    resizeBootstrapTable(plugin.$bootstrapTable);
            },

            onSearch: function () {
                this.formatLoadingMessage();
            },

            rowStyle : function (row, index ,params) {
                if (plugin.colorCompra) {
                    if (parseInt(row.status) == 30 ) {
                        if (parseInt(row.diferencia) != 0 ) {
                            return {
                                classes : "label-warning",
                            }
                        }
                    }
                }

                return {
                    classes : "white",
                }
            }
        };

        bootstrapTableParams = Object.assign(bootstrapTableParamsDefault, params.bootstrapTable);

        plugin.$bootstrapTable.bootstrapTable(bootstrapTableParams);




        // Filtros y agrupación
        plugin.refresh = function(){

            plugin.$bootstrapTable.bootstrapTable('refresh', {'url': plugin.url});
        }





        // Responsivo
            plugin.resize = function(timeout){
                setTimeout(function(){
                    resizeBootstrapTable(plugin.$bootstrapTable);
                }, timeout);
            }

            if(plugin.autoHeight !== false){
                $(window).resize(function(){
                    //plugin.$bootstrapTable.bootstrapTable('hideLoading');
                    resizeBootstrapTable(plugin.$bootstrapTable);
                });

                plugin.resize(1000);
            }


            plugin.$filters
            .on('change', function(){

               plugin.refresh();

            });
            //.trigger('change');


        /*$(window).resize(function(){
            resizeBootstrapTable(plugin.$bootstrapTable);
            console.log("entroo 2");
        });*/


        /*plugin.refresh = function(){
            plugin.$bootstrapTable.bootstrapTable('refresh', {'url': plugin.url});

            setTimeout(function(){
                resizeBootstrapTable(plugin.$bootstrapTable);
            }, 1000);
        }*/

    }

// Base64 String XML to HTML
    function XMLbase64ToHtml(xml, $element, utf8decode = true) {
        var xml         = utf8decode? decode_utf8(atob((xml))): atob(xml),
            replaceArgs = htmlEntities(xml);

        $element.html(replaceArgs);
    }

    function htmlEntities(str) {
       return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
    }

    function encode_utf8(s) {
      return unescape(encodeURIComponent(s));
    }

    function decode_utf8(s) {
      return decodeURIComponent(escape(s));
    }


// Treeview
    var glyph_opts = {
        map: {
            doc: "glyphicon glyphicon-file",
            docOpen: "glyphicon glyphicon-file",
            checkbox: "glyphicon glyphicon-unchecked",
            checkboxSelected: "glyphicon glyphicon-check",
            checkboxUnknown: "glyphicon glyphicon-share",
            dragHelper: "glyphicon glyphicon-play",
            dropMarker: "glyphicon glyphicon-arrow-right",
            error: "glyphicon glyphicon-warning-sign",
            expanderClosed: "glyphicon glyphicon-menu-right",
            expanderLazy: "glyphicon glyphicon-menu-right",  // glyphicon-plus-sign
            expanderOpen: "glyphicon glyphicon-menu-down",  // glyphicon-collapse-down
            folder: "glyphicon glyphicon-folder-close",
            folderOpen: "glyphicon glyphicon-folder-open",
            loading: "glyphicon glyphicon-refresh glyphicon-spin"
        }
    };

// MINUSCULA A MAYUSCULA

var funcLowerCase = function(input){
    return  $.trim($(input).val($(input).val().toUpperCase()));
}

// Alert


var toast2 = function(title, message, tipo){

    if (tipo == 'warning')
        swal({
            title: title,
            type: tipo,
            text: message
        });

    if (tipo == 'success')
        swal({
            title: title,
            type: tipo,
            text: message
        });

    if (tipo == 'danger')
        swal({
            title: title,
            type: tipo,
            text: message
        });
}


var toast2Bold = function(title, message, tipo){

    if (tipo == 'warning')
        swal({
            title: title,
            type: tipo,
            html: true,
            text : '<strong style="font-size: 16px;font-weight: 700;color: #000;">'+ message +'</strong>'
        });

    if (tipo == 'success')
        swal({
            title: title,
            type: tipo,
            html: true,
            text : '<strong style="font-size: 16px;font-weight: 700;color: #000;">'+ message +'</strong>'
        });

    if (tipo == 'danger')
        swal({
            title: title,
            type: tipo,
            html: true,
            text : '<strong style="font-size: 16px;font-weight: 700;color: #000;">'+ message +'</strong>'
        });
}

  
// BootstrapTable - Format
    var btf = {
        status : 
        {

            opt_a : function (value) {
                if(value == 10) return '<span style="color:#177F75;font-weight: 900;">ACTIVO</span>';

                if(value == 20) return '<span style="color:#FF8362;font-weight: 900;">INACTIVO</span>';

                if(value == 1) return '<span style="color:#FF8362;font-weight: 900;">INACTIVO</span>';

                if(value == 0) return '<span style="color:#D23641;font-weight: 900;">ELIMINADO</span>';

                else return value;
            },



            opt_check : function (value) {
                if(value == 10) return '<i class="fa fa-check-square-o" style="color:#177F75;" aria-hidden="true"></i>';

                if(value == 20) return '<i class="fa fa-times"  style="color:#D23641;" aria-hidden="true"></i>';

                if(value == 1) return '<i class="fa fa-times" aria-hidden="true"></i>';

                if(value == 0) return '<i class="fa fa-times" aria-hidden="true"></i>';

                if(value == null) return '<i class="fa fa-times" aria-hidden="true"></i>';

                else return value;
            },

            system_cierre : function (value) {
                if(value == 10) return '<span style="color:#FF8362;font-weight: 900;">PROCESO</span>';

                if(value == 20) return '<span style="color:#D23641;font-weight: 900;">ERROR</span>';

                if(value == 30) return '<span style="color:#177F75;font-weight: 900;">TERMINO</span>';

                else return value;
            },

            condusef : function (value) {
                if(value == 1) return '<span style="color:#FF8362;font-weight: 900;">PENDIENTE</span>';

                if(value == 2) return '<span style="color:#177F75;font-weight: 900;">CONCLUIDO</span>';

                else return value;
            },

            condusef_sistema : function (value) {
                if(value == 10) return '<span style="color:#FF8362;font-weight: 900;">ENVIO/PENDIENTE</span>';

                if(value == 20) return '<span style="color:#177F75;font-weight: 900;">REPORTADO CONDUSEF</span>';

                else return value;
            },

        },

        solicitud    :
        {
            status : function (value) {
                if(value == 40) return '<span style="font-weight: 900;">TERMINADO</span>';

                if(value == 30) return '<span style="font-weight: 900;">RESOLUCUCION</span>';

                if(value == 20) return '<span style="font-weight: 900;">ANALISIS</span>';

                if(value == 10) return '<span style="font-weight: 900;">INTEGRACION</span>';

                if(value == 2) return '<span style="font-weight: 900;">DENEGADO</span>';

                if(value == 1) return '<span style="font-weight: 900;">CANCELADO</span>';

                else return value;
            },

            tipo_tasa : function (value) {
                if(value == 10) return '<span style="color:#000;font-weight: 900;">TASA FIJA</span>';

                if(value == 20) return '<span style="color:#000;font-weight: 900;">TASA VARIABLE</span>';

                else return value;
            },
        },

        garantia :
        {
            tipo : function (value) {
                if(value == 10) return '<span style="color:#000;font-weight: 900;">RANCHO</span>';

                if(value == 20) return '<span style="color:#000;font-weight: 900;">TERRENO</span>';

                if(value == 30) return '<span style="color:#000;font-weight: 900;">INMUEBLE</span>';

                else return value;
            },
            unidad : function (value) {
                if(value == 10) return '<span style="color:#000;font-weight: 900;">HAS</span>';

                if(value == 20) return '<span style="color:#000;font-weight: 900;">M2</span>';

                if(value == 30) return '<span style="color:#000;font-weight: 900;">M3</span>';

                else return value;
            },

        },
        credito    : 
        {
            status : function (value) {
                if(value == 40) return '<span style="color:#D23641;font-weight: 900;">VENCIDO</span>';

                if(value == 30) return '<span style="color:#ea5b0c;font-weight: 900;">PAGADA</span>';

                if(value == 25) return '<span style="color:#0c6cea;font-weight: 900;">RENOVACION</span>';

                if(value == 20) return '<span style="color:#FF8362;font-weight: 900;">IMPAGO</span>';

                if(value == 10) return '<span style="color:#177F75;font-weight: 900;">VIGENTE</span>';

                if(value == 2) return '<span style="color:#177F75;font-weight: 900;">AUTORIZADO</span>';

                if(value == 1) return '<span style="color:#D23641;font-weight: 900;">CANCELADO</span>';

                else return value;
            },
            status_balance : function (value) {

                if(value == 30) return '<span style="color:#ea5b0c;font-weight: 900;">ETAPA 3</span>';

                if(value == 20) return '<span style="color:#b5a938;font-weight: 900;">ETAPA 2</span>';

                if(value == 10) return '<span style="color:#177F75;font-weight: 900;">ETAPA 1</span>';

                else return '<span style="color:#177F75;font-weight: 900;">----</span>';
            },
            tipo_dispersion : function (value) {
                if(value == 10) return '<span style="color:#177F75;font-weight: 900;">TRANSFERENCIA</span>';

                if(value == 20) return '<span style="color:#ea5b0c;font-weight: 900;">CHEQUE</span>';

                else return value;
            },

            pertenece : function (value) {
                if(value == 10) return '<span style="font-weight: 900;">PROCESO</span>';

                if(value == 20) return '<span style="font-weight: 900;">SISTEMA</span>';

                else return value;
            },

            tipo_movimiento : function (value) {
                if(value == 10) return '<span style="color:#177F75;font-weight: 900;">DISPOSICION DE CREDITO</span>';

                if(value == 20) return '<span style="color:#000000;font-weight: 900;">INTERES ORDINARIO [DIARIO]</span>';

                if(value == 21) return '<span style="color:#999904;font-weight: 900;">INTERES ORDINARIO [EXIGIBLE]</span>';

                if(value == 22) return '<span style="color:#ea0c0c;font-weight: 900;">INTERES ORDINARIO [VENCIDO]</span>';

                if(value == 30) return '<span style="color:#ea0c0c;font-weight: 900;">INTERES MORATORIO [DIARIO]</span>';

                if(value == 40) return '<span style="color:#0c6dea;font-weight: 900;">PAGO DE INTERESES ORDINARIO (VIGENTE)</span>';

                if(value == 45) return '<span style="color:#0c6dea;font-weight: 900;">PAGO DE INTERESES ORDINARIO (VENCIDOS)</span>';

                if(value == 50) return '<span style="color:#0c6dea;font-weight: 900;">PAGO DE INTERESES MORATORIO</span>';

                if(value == 60) return '<span style="color:#0c6dea;font-weight: 900;">PAGO DE AMORTIZACION</span>';

                if(value == 70) return '<span style="color:#0c6dea;font-weight: 900;">PAGO DE CAPITAL</span>';

                if(value == 80) return '<span style="color:#0c94ea;font-weight: 900;">CAPITAL EXIGIBLE</span>';

                if(value == 90) return '<span style="color:#ea0c0c;font-weight: 900;">CAPITAL VENCIDO</span>';

                if(value == 100) return '<span style="color:#0c6dea;font-weight: 900;">AMORTIZACION EXIGIBLE</span>';

                if(value == 110) return '<span style="color:#0c6dea;font-weight: 900;">PAGO PRINCIPAL</span>';

                if(value == 120) return '<span style="color:#0c6dea;font-weight: 900;">PAGO COMISION POR DISPOSICION</span>';

                if(value == 121) return '<span style="color:#0c6dea;font-weight: 900;">PAGO COMISION POR DISPOSICION - IVA</span>';

                if(value == 122) return '<span style="color:#eab50c;font-weight: 900;">COMISION POR DISPOSICION</span>';

                if(value == 123) return '<span style="color:#eab50c;font-weight: 900;">COMISION POR DISPOSICION - IVA</span>';

                if(value == 131) return '<span style="color:#eab50c;font-weight: 900;">CARGO COMISION PAGO ANTICIPADO</span>';


                if(value == 140) return '<span style="color:#0c6dea;font-weight: 900;">COMISION PAGO ANTICIPADO</span>';

                if(value == 141) return '<span style="color:#0c6dea;font-weight: 900;">COMISION PAGO ANTICIPADO IVA</span>';

                if(value == 160) return '<span style="color:#eab50c;font-weight: 900;">COMISION CARGO PAGO ANTICIPADO</span>';

                if(value == 161) return '<span style="color:#eab50c;font-weight: 900;">COMISION CARGO PAGO ANTICIPADO IVA</span>';

                else return value;
            },
        },
        disposicion    :
        {
            status : function (value) {

                if(value == 20) return '<span style="color:#FF8362;font-weight: 900;">PROCESO</span>';

                if(value == 10) return '<span style="color:#177F75;font-weight: 900;">TERMINADO</span>';

                else return value;
            },
        },
        producto : 
        {
            unidad : function(value){
                if(value == 10) return '<span style="font-weight: 900;">Piezas</span>';

                if(value == 20) return '<span style="font-weight: 900;">Kilos</span>';

                if(value == 30) return '<span style="font-weight: 900;">Metro</span>';

                if(value == 40) return '<span style="font-weight: 900;">Litro</span>';
            },
            inv : function(value){
                if(value == 10) return '<i class="fa fa-check-square-o" aria-hidden="true"></i>';

                if(value == 20) return '<i class="fa fa-times" aria-hidden="true"></i>';
            },
        },
        tipo :
        {
            person : function(value){
                if(value == 10) return '<span style="font-weight: 900;">PF</span>';

                if(value == 20) return '<span style="font-weight: 900;">PM</span>';

                if(value == 30) return '<span style="font-weight: 900;">PF [EXT]</span>';

                if(value == 40) return '<span style="font-weight: 900;">PM [EXT]</span>';
            },
        },

        color : {
            green : function( value ){
                return '<span style="color:#177F75;font-weight: 900;">' + value + '</span>';
            },
            bold : function( value ){
                return '<span style="color:#000;font-weight: 900;">' + value + '</span>';
            },
            bold_underline : function( value ){
                return '<span style="color:#000;font-weight: 900;text-decoration:underline">' + value + '</span>';
            },
            red : function( value ){
                return '<span style="color:#f42323;font-weight: 900;">' + value + '</span>';
            },
            widget_card : function( value ){
                return '<span style="background: #92d050;padding: 6px;border-radius: 45%;color: #000;font-weight: 800;">' + value + '</span>';
            }
        },

        time : {
            date : function (value) {
                return value && value != 0 ? new Date(value * 1000).format("d/m/Y"): '';
            },
            date_underline : function (value) {
                return value && value != 0 ? '<span style="text-decoration: underline; color: #000; font-weight:500">' + new Date(value * 1000).format("d/m/Y") + '</span>': '';
            },
            datetime : function (value) {
                return value && value != 0 ? new Date(value * 1000).format("Y-m-d h:i a"): '';
            },
            /*
            millis : function (value) {
                return value? ((Math.round(value / 10)) / 100) + ' s'  : '';
            },
            date_dia : function (value) {
                return value? new Date(value * 1000).format("d"): '';
            },
            date_mes : function (value) {
                value = parseInt(value? new Date(value * 1000).format("m"): '');

                switch(value){
                    case 1:  return 'Enero';
                    case 2:  return 'Febrero';
                    case 3:  return 'Marzo';
                    case 4:  return 'Abril';
                    case 5:  return 'Mayo';
                    case 6:  return 'Junio';
                    case 7:  return 'Julio';
                    case 8:  return 'Agosto';
                    case 9:  return 'Septiembre';
                    case 10: return 'Octubre';
                    case 11: return 'Noviembre';
                    case 12: return 'Diciembre';
                }
            },
            date_ano : function (value) {
                return value? new Date(value * 1000).format("Y"): '';
            },
            datetime2 : function (value) {
                return value? new Date(value * 1000).format("h:i a / Y-m-d"): '';
            },
            time : function (value) {
                return value? new Date(value * 1000).format("h:i a"): '';
            },
            segToTime : function (value) {
                if(value == null)
                    return '';

                var horas, minutos, segundos, string_time;

                if(value >= 3600){
                    horas = parseInt(value / 3600);
                    value = value - (horas * 3600);

                    string_time = horas + "h";
                }

                if(value >= 60){
                    minutos = parseInt(value / 60);
                    value   = value - (minutos * 60);

                    string_time = (string_time? string_time + ' ': '') + minutos + "m";
                }

                if(!horas && !minutos){
                    string_time = value + "s";
                }

                return string_time;
            },
            dias : function (value) {
                return value + (value > 1 || value == 0? ' días': ' día');
            },
            */

            //'updated_sucursal_id',


            minutos : function (value) {
                return value? value + ' Min': '';
            },
            dia_semana : function (value) {
                value = parseInt(value);

                switch(value){
                    case 1:  return 'Lunes';
                    case 2:  return 'Martes';
                    case 3:  return 'Miercoles';
                    case 4:  return 'Jueves';
                    case 5:  return 'Viernes';
                    case 6:  return 'Sabado';
                    case 7:  return 'Domingo';
                }
            },
            mes : function (value) {
                value = parseInt(value);

                switch(value){
                    case 1:  return 'Enero';
                    case 2:  return 'Febrero';
                    case 3:  return 'Marzo';
                    case 4:  return 'Abril';
                    case 5:  return 'Mayo';
                    case 6:  return 'Junio';
                    case 7:  return 'Julio';
                    case 8:  return 'Agosto';
                    case 9:  return 'Septiembre';
                    case 10: return 'Octubre';
                    case 11: return 'Noviembre';
                    case 12: return 'Diciembre';
                }
            },
            timezone : function (value) {
                switch (parseInt(value)) {
                    case -5: return "Tiempo del Sureste: UTC -5";
                    case -6: return "Tiempo del Centro: UTC –6 (UTC –5 en verano)";
                    case -7: return "Tiempo del Pacífico: UTC–7 (UTC–6 en verano)";
                    case -8: return "Tiempo del Noroeste: UTC–8 (UTC–7 en verano)";
                }
            },
        },
        conta : {
            money_info : function (value) {
                if(!isNaN(value)){
                    value = parseFloat(value);

                    return value > 0 ? '<span style="color: #0561e7;font-weight: 800;text-decoration: underline;">$' + value.formatMoney(2, '.', ',')+ '</span>' : '$' + value.formatMoney(2, '.', ',') ;
                }
            },

            money_blue : function (value) {
                if(!isNaN(value)){
                    value = parseFloat(value);

                    return value > 0 ? '<span style="color: #0c94ea;font-weight: 800;text-decoration: underline;">$' + value.formatMoney(2, '.', ',')+ '</span>' : '$' + value.formatMoney(2, '.', ',') ;
                }
            },

            money_danger : function (value) {
                if(!isNaN(value)){
                    value = parseFloat(value);

                    return value > 0 ? '<span style="color: #7f1717;font-weight: 800;text-decoration: underline;">$' + value.formatMoney(2, '.', ',')+ '</span>' : '$' + value.formatMoney(2, '.', ',') ;
                }
            },
            money_success : function (value) {
                if(!isNaN(value)){
                    value = parseFloat(value);

                    return value > 0 ? '<span style="color: #177F75;font-weight: 800;text-decoration: underline;">$' + value.formatMoney(2, '.', ',')+ '</span>' : '$' + value.formatMoney(2, '.', ',') ;
                }
            },
            money : function (value) {
                if(!isNaN(value)){
                    value = parseFloat(value);

                    return '$' + value.formatMoney(2, '.', ',');
                }
            },
            miles : function (value) {
                if(!isNaN(value)){
                    value = parseFloat(value);

                    return  value.formatMoney(2, '.', ',');
                }
            },
            porcentaje : function (value) {
                return value > 0? (value * 1) + ' %': '';
            },
            number : function (value) {
                return value? (value * 1): '';
            },
            moneyDeuda : function (value) {
                if(!isNaN(value)){
                    value = parseFloat(value);

                    return '<span class="text-danger">$' + value.formatMoney(2, '.', ',') + "</span>";
                }
            },
        },
        boolean : {
            /*
            sino : function (value) {
                return value > 0? '<span style="display:none">Si</span><i class="fa fa-check text-primary"></i>': '';
            },
            */
        },
        ui : {
            /*
            barcode : function (value) {
                return value.substr(0, 1) + '****' + value.substr(5, 2);
            },
            tel_ext : function(value, row) {
                return '<a href="tel:' + row.tel + '" class="text-primary">' + row.tel + '</a>' + (row.tel_ext? ' Ext. ' + row.tel_ext: '');
            },
            direccion : function(value, row) {
                return row.direccion + (row.num_ext? ' No. ' + row.num_ext: '') + (row.num_int? ' Int. ' + row.num_int: '') + ', ' + row.colonia + (row.cp? ', C.P. ' + row.cp: '');
            },
            */
            pres_u_de_uso : function (value, row) {
                if(row.presentacion != null || row.unidades != null){
                    var presentacion  = row.unidades <= 1? row.presentacion: row.presentacion_plural,
                        unidad_de_uso = row.unidades <= 1? row.unidad_de_uso: row.unidad_de_uso_plural,
                        pres_u_de_uso = presentacion != null? presentacion: '';

                    pres_u_de_uso += row.presentacion != null || row.unidades != null? ' ': '';
                    pres_u_de_uso += unidad_de_uso? (row.unidades * 1) + ' ' + unidad_de_uso: '';

                    return pres_u_de_uso;
                }
            },
            checkbox : function (value) {
                return value > 0? '<span style="display:none">Si</span><i class="fa fa-check text-primary"></i>': '';
            },
            rating : function (value) {
                return html_rating(parseInt(value));
            },
            edad : function (value) {
                return value? value + ' años': '';
            },
            veces : function (value) {
                if(value == 0)
                    return 'Ninguna';

                if(value == 1)
                    return '1 vez';

                return value + ' veces';
            },
            hace_dias : function (value) {
                if(value){
                    if(value == 0)
                        return 'Hoy';

                    return 'hace ' + value + (value > 1? ' días': ' día');
                }
            },
            tel : function(value) {
                return '<a href="tel:' + value + '" class="text-primary">' + value + '</a>';
            },
            mailto : function(value) {
                return value != null? '<a href="mailto:' + value + '" class="text-primary">' + value + '</a>': '';
            },
        },
        user : {
            /*
            full_name : function(value, row) {
                return row.nombre + ' ' + row.apellidos;
            },
            user_admin : function(value, row) {
                return row.admin_id? row.admin + ' [' + row.admin_id + ']': '';
            },
            asignado : function(value, row) {
                return row.asignado_id? row.asignado + ' [' + row.asignado_id + ']': '';
            },
            asignado_a : function(value, row) {
                return row.asignado_a + (row.asignado_a_id? ' [' + row.asignado_a_id + ']': '');
            },
            encargado : function(value, row) {
                return row.encargado_id? row.encargado + ' [' + row.encargado_id + ']': '';
            },
            user_nombre : function(value, row) {
                return row.user_id? row.user_nombre + ' [' + row.user_id + ']': '';
            },
            user_destino_uid : function(value, row) {
                return row.user_destino_uid? row.user_destino_name + ' [' + row.user_destino_uid + ']': '';
            },
            cliente : function(value, row) {
                return row.cliente_id? row.cliente + ' [' + row.cliente_id + ']': '';
            },
            cliente_nombre : function(value, row) {
                return row.cliente_id? row.cliente_nombre + ' [' + row.cliente_id + ']': '';
            },
            created_by_uid : function(value, row) {
                return row.created_by_uid? row.created_by_user + ' [' + row.created_by_uid + ']': '';
            },
            */
            user_name : function(value, row) {
                return row.user_id? row.user_name + ' [' + row.user_id + ']': '';
            },
            created_by : function(value, row) {
                return row.created_by? row.created_by_user + ' [' + row.created_by +']': '';
            },
            updated_by : function(value, row) {
                return row.updated_by? row.updated_by_user + ' [' + row.updated_by + ']': '';
            },
            sexo : function (value) {
                switch (parseInt(value)) {
                    case 10: return "Hombre";
                    case 20: return "Mujer";
                }
            },
        },
        trc : function (value) {
            switch (value) {
                case '1':  return 'Compra';
                case '2':  return 'Compra cancelada';
                case '3':  return 'Compra eliminada';
                case '4':  return 'Venta';
                case '5':  return 'Venta cancelada';
                case '6':  return 'Venta eliminada';
                case '7':  return 'Ajuste manual';
                case '8':  return 'Ajuste manual cancelado';
                case '9':  return 'Ajuste manual eliminado';
                case '10': return 'Traspaso';
                case '11': return 'Traspaso cancelado';
                case '12': return 'Traspaso eliminado';
                default:   return value;
            }
        },
    }



