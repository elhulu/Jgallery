<div class="section">
    <div class="centerhome">
        <div class="innera">
            <!-- your content here -->
        </div>
        <div class="innerb">
            <div class="innertitle"></div>
        </div>
    </div>
</div>

<div class="section2">
    <div class="inner2">
        <!-- your content here -->
    </div>
</div>

<div class="section3">
    <div class="centerhome">
        <div class="inner3a">
            <!-- your content here -->
        </div>
        <div class="inner3b">

        </div>
    </div>
</div>


<script type="text/javascript">
    // The plugin code
    (function($){
        $.fn.parallax = function(options){
            var $$ = $(this);
            offset = $$.offset();
            var defaults = {
                "start": 0,
                "stop": offset.top + $$.height(),
                "coeff": 0.95
            };
            var opts = $.extend(defaults, options);
            return this.each(function(){
                $(window).bind('scroll', function() {
                    windowTop = $(window).scrollTop();
                    if((windowTop >= opts.start) && (windowTop <= opts.stop)) {
                        newCoord = windowTop * opts.coeff;
                        $$.css({
                            "background-position": "0 "+ newCoord + "px"
                        });
                    }
                });
            });
        };
    })(jQuery);

    // call the plugin
    $('.section').parallax({ "coeff":-0.65 });
    $('.section .innera').parallax({ "coeff":1.15 });
    $('.section .innerb').parallax({ "coeff":1.60 });
    $('.section .innertitle').parallax({ "coeff":1.90 });

    $('.section2').parallax({ "coeff":-0.65 });
    $('.section2 .inner2').parallax({ "coeff":-0.80 });


    $('.section3').parallax({ "coeff":-0.01 });
    $('.section3 .inner3a').parallax({ "coeff":0.50 });
    $('.section3 .inner3b').parallax({ "coeff":0.20 });


</script>