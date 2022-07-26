var data_ccollapse_values;
$(document).ready(function () {
    $(".collapse-section-btn").click(function () {
        let btn = this;
        if ($(btn).hasClass('collapsed')) {
            $(btn).html('View Less');
        } else {
            $(btn).html('View More');
        }
    });
    $(".data-ccollapse").each(function () {
        let elem = this;
        var defined_height = $(elem).attr('data-max-height');
        let height = $(elem).height() + 25;
        if (typeof defined_height !== 'undefined' && defined_height !== false) {
        } else {
            defined_height = 150;
        }
        $(elem).css({'max-height':defined_height+'px'});
        $(elem).attr('total-height', height);
    });
    $(".ccollapse-btn").click(function () {
        let btn = this;

        let defined_height = $($(btn).attr('data-ccollapse-section')).attr('data-max-height');
        if (typeof defined_height !== 'undefined' && defined_height !== false) {
        } else {
            defined_height = 150;
        }
        // console.log(defined_height);
        let total_height = $($(btn).attr('data-ccollapse-section')).attr('total-height');
        if (typeof total_height !== 'undefined' && total_height !== false) {
        } else {
            total_height = defined_height * 2;
        }

        if ($($(btn).attr('data-ccollapse-section')).hasClass('show')) {
            $($(btn).attr('data-ccollapse-section')).css({'max-height':defined_height+'px'});
            $(btn).html('View More');
            setTimeout(function () {
                $($(btn).attr('data-ccollapse-section')).removeClass('show');
            }, 600);
        } else {
            $($(btn).attr('data-ccollapse-section')).css({'max-height':'inherit'});
            $(btn).html('View Less');
            setTimeout(function () {
                $($(btn).attr('data-ccollapse-section')).addClass('show');
            }, 600);
        }
    });
});
