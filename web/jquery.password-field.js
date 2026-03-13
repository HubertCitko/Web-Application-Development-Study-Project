/* Jquey PasswordField
 * Version: 1.00
 * Author: Prefect9
 * TG: https://t.me/it_dev9/
 */
(function ($) {
    "use strict";
    try {
        $.fn.passwordField = function () {
            var _this = $(this)
            for(var input of _this) PasswordField({ container: input })
        }
        var PasswordField = function (options) {
            var _container = $(options.container),
                _input = _container.find("input"),
                _btn = _container.find("[data-password-field-btn]")
            if(_container[0]["passwordfield-init"] === true) throw "This container has already been initialized"
            if(_input.length != 1) throw "The field in the container was not found or there are several of them"
            if(_btn.length != 1) throw "The field-btn in the container was not found or there are several of them"
            _container[0]["passwordfield-init"] = true

            var show_password = function () {
                _input.attr("type", "text")
                _container.attr("data-password-shown", "")
            }
            var hide_password = function () {
                _input.attr("type", "password")
                _container.removeAttr("data-password-shown")
            }

            if(_input.attr("type") == "password") hide_password()
            else show_password()

            _btn.on("click", function (e) {
                e.preventDefault()
                if(_input.attr("type") == "password") show_password()
                else hide_password()
            })
            _btn.on("mousedown", function (e) {
                e.preventDefault()
            })
        }
        window.PasswordField = PasswordField
        window.PasswordFieldVersion = "1.00"
        $("[data-password-field]").passwordField()
    }catch (e) {
        console.error("PasswordField error: "+e)
    }
})(jQuery)