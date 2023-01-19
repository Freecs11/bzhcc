function formsubmit() {
    var textS = document.getElementById('textSearch').value;
    var sel = document.getElementById('select-1');
    var seltext = sel.options[sel.selectedIndex].text;
    return 'search.php?textSearch=' + textS + '&selection=' + seltext;
}