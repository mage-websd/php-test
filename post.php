<script type="text/javascript">
var array = [];
$('#wiki-body .markdown-body > table').each(function(a,b) {
    if (a == 0) {
        return true;
    }
    $(b).children('tbody').children('tr').each(function(c,d){
        array.push($(d).children('td:first').text());
    });
});

$('#wiki-body .markdown-body > ul > li').each(function(a,b) {
    array.push($(b).children('a:first').text());
});
var string = '';
for (i in array) {
    string += "'" + array[i] + "',<br/>";
}
$('body').html(string);
</script>