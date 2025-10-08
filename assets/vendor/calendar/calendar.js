document.addEventListener('DOMContentLoaded', function(){
    const calendar = new Calendar({
        container: '#calendar',
        listContainer: '#list-view',
        dataUrl: 'getData.php',
    });

    calendar.init();
});