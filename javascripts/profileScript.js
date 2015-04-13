$(document).ready(function () {
    $('#btnLeftNav').click(function () {
        if ($('#leftGlyphicon').hasClass('glyphicon-chevron-right')) {
            $('#LeftColumn').removeClass('hidden-xs').addClass('col-xs-12');
            $('#MainFeed').removeClass('col-xs-12').addClass('hidden-xs');
            $('#leftGlyphicon').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');
            if ($('#rightGlyphicon').hasClass('glyphicon-chevron-right')) {
                $('#MessageCenterPanel').removeClass('col-xs-12').addClass('hidden-xs');
                $('#rightGlyphicon').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');
            }
        }
        else if ($('#leftGlyphicon').hasClass('glyphicon-chevron-left')) {
            $('#LeftColumn').removeClass('col-xs-12').addClass('hidden-xs');
            $('#MainFeed').removeClass('hidden-xs').addClass('col-xs-12');
            $('#leftGlyphicon').removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');
        }
    });

    $('#btnRightNav').click(function () {
        if ($('#rightGlyphicon').hasClass('glyphicon-chevron-left')) {
            $('#MessageCenterPanel').removeClass('hidden-xs').addClass('col-xs-12');
            $('#MainFeed').removeClass('col-xs-12').addClass('hidden-xs');
            $('#rightGlyphicon').removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');
            if ($('#leftGlyphicon').hasClass('glyphicon-chevron-left')) {
                $('#LeftColumn').removeClass('col-xs-12').addClass('hidden-xs');
                $('#leftGlyphicon').removeClass('glyphicon-chevron-left').addClass('glyphicon-chevron-right');
            }
        }
        else if ($('#rightGlyphicon').hasClass('glyphicon-chevron-right')) {
            $('#MessageCenterPanel').removeClass('col-xs-12').addClass('hidden-xs');
            $('#MainFeed').removeClass('hidden-xs').addClass('col-xs-12');
            $('#rightGlyphicon').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-left');
        }
    });
});