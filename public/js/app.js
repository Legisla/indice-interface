// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();
/* Slider da página inicial */

/* Máscara para telefone */
$(document).ready(function () {
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 50) {
            $(".header").addClass("change");
        } else {
            $(".header").removeClass("change");
        }
    });

    /*** MENU CLASS SCROLL ***/
    $(".filtro_box .box_explorador").click(function () {
        $(".filtro_estado").toggle();
    });

    $(".box_filtro_busca .box_explorador").click(function () {
        $(".filtro_busca").toggle();
    });

    $(".telefone").mask('(99) 999999999');
    $(".cep").mask('99999-999');
    $(".cpf").mask('999.999.999-99');
    $(".data").mask('99/99/9999');

    /* Esconder e abrir hamburguer menu */
    $(".m-menu").click(function () {
        $("#main-menu").toggle();
    });

    $('.explorerSelectState').change(function () {
        const value = $(this).val();
        $('.explorerSelectState').each(function () {
            if ($(this).val() !== value) {
                $(this).val(value);
            }
        });
        redirectToExplorer();
    });

    $('.explorerSelectRate').change(function () {
        redirectToExplorer();
    });

    $('#stateSelectorExplorerPanel').change(function () {

        const acronym = $(this).val();

        $('.stateSubstitute').html($(this).find(':selected').attr('data-name').toUpperCase());

        $('.substituteLink').each(function () {
            let href = $(this).attr('href');
            $(this).attr('href', href.replace('/br/', '/' + acronym + '/'));
        });

        $('#modal_filtro_porperty').foundation('reveal', 'open');
    });


    $('.filterSelectState').change(function () {
        redirectToFilter()
    });
    $('.filterSelectRate').change(function () {
        redirectToFilter()
    });

    $('.rangeCustomIndex').on("input change",function () {

        let text = 'relevante';
        let style = '50% 100%';
        if ($(this).val() === '0') {
            style = '0% 100%';
            text = 'não relevante (x0)';
        }

        if ($(this).val() === '1') {
            style = '50% 100%';
            text = ' relevante (x1)';
        }

        if ($(this).val() === '2') {
            style = '100% 100%';
            text = 'muito relevante (x2)';
        }
        $(this).css('background-size', style).siblings('.textRelevance').html(text);
        checkChecks();
    });

    $('.customindexsubmit').click(function (e) {
        let checked = false;
        $('.rangeCustomIndex').each(function (range) {
            if ($(this).val() !== '1') {
                checked = true;
            }
        });
        if (!checked) {
            e.preventDefault();
        }else{
            $(this).parent('forms').submit();
        }
    });

    $('#stateCustomIndex').change(function () {
        $('#hiddenInputState').val($(this).val());
        $('#hiddenForm').submit();
    });
    $('#classificationCustomIndex').change(function () {
        $('#hiddenInputClassification').val($(this).val());
        $('#hiddenForm').submit();
    });

});


function checkChecks() {
    let checked = false;
    $('.rangeCustomIndex').each(function () {
        if ($(this).val() !== '1') {
            checked = true;
        }
    });
    if (checked) {
        $('.customindexsubmit').removeClass('disabled');
    } else {
        $('.customindexsubmit').addClass('disabled');
    }
}

function redirectToExplorer() {
    const state = $('.explorerSelectState').val() || null;
    const rate = $('.explorerSelectRate').val() || null;

    if (!state && rate) {
        location.href = baseUrl + '/explorador/' + rate;
    }

    if (state && rate) {
        location.href = baseUrl + '/explorador/' + rate + '/' + state.toLowerCase();
    }

    if (state && !rate) {
        location.href = baseUrl + '/explorador/estado/' + state.toLowerCase();
    }

    if (!state && !rate) {
        location.href = baseUrl + '/explorador/';
    }
}

function redirectToFilter() {
    const stateSelect = $('.filterSelectState');
    const state = stateSelect.val() || 'br';
    const rate = $('.filterSelectRate').val() || null;
    const uri = stateSelect.attr('data-params');

    if (rate) {
        location.href = baseUrl + '/explorador/filtro/' + state.toLowerCase() + uri + rate;
    }

    if (state && !rate) {
        location.href = baseUrl + '/explorador/filtro/' + state.toLowerCase() + uri;
    }
}











