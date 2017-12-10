/**
 * @description Ввод текста в строку поиска
 */
$(function () {
    $("input.search__input").keyup(function (e) {
        if (e.keyCode === 13) {
            Search();
        }
    });
});
