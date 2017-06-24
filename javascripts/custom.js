/**
 * Created by Mat on 6/23/2017.
 */
/* Skill block animations
 *  */
$(function () {
    $('.skill-block').hover(function () {
        if ($('.skill-block.active').length > 0)
            $('.skill-block.active').removeClass('active');
        $(this).addClass('active');
    });

});

/**
 * Change Password verify
 */
$(function () {
    $('.editemail .pass').on('blur focus', function () {
        $('.editemail .alert.invalid').remove();
        var val = $(this).val();
        var check = checkPassword(val);
        if (check != true) {
            $('.editemail').prepend($('<div>', {class: 'alert alert-warning invalid'}).prepend($('<ul>', {class: 'invalid-pass'})));
            for (i = 0; i < check.length; i++) {
                $('.editemail ul.invalid-pass').append($('<li>', {text: check[i]}));
            }
        }
        if($('.editemail .alert').length > 0)
            $('.editemail input[type="submit"]').attr('disabled', 'disabled');
        else
            $('.editemail input[type="submit"]').removeAttr('disabled');
    });
    $('.editemail .validate').on('blur focus', function () {
        $('.editemail .alert.mismatch').remove();
        if ($(this).val() != $('.editemail .pass').val()) {
            $('.editemail').prepend($('<div>', {class: 'alert alert-danger mismatch'})
                .prepend($('<ul>'))
                .append($('<li>', {text: 'Passwords do not match.'}))
            );
        }
        if($('.editemail .alert').length > 0)
            $('.editemail input[type="submit"]').attr('disabled', 'disabled');
        else
            $('.editemail input[type="submit"]').removeAttr('disabled');
    });
});
/**
 * Admin Panels
 */
//////////////////////////Domain//////////////////
$(function () {

});

function checkPassword(pass) {
    var error = [];
    if (pass.length < 8)
        error.push("The password must be at least 8 characters long.");
    if (!hasSpclChar(pass))
        error.push("The password must have a special character.");
    return (error.length != 0) ? error : true;
}

function hasSpclChar(pass) {
    var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
    for (var i = 0; i < pass.length; i++) {
        if (iChars.indexOf(pass.charAt(i)) != -1) {
            return true;
        }
    }
    return false;
}
function preventDefault(e) {
    e.preventDefault();
}