/* Created by Mitxel on 10/05/2015. */
$(document).ready(function() {
    var schools_tbody = $("tbody#schools");
    schools_tbody.on("click", "a[class*='status-']", function (e) {
        e.preventDefault();
        var btn = $(this);
        var schoolId = btn.closest('tr').find('.school-id').val();
        var activeStatus;
        btn.addClass('hidden');
        if (btn.hasClass('status-active')) {
            btn.next().removeClass('hidden');
            activeStatus = false;
        } else {
            btn.prev().removeClass('hidden');
            activeStatus = true;
        }
        $.post('/admin/updateSchoolStatus',
            {
                '_token': $('#token').val(),
                schoolId: schoolId,
                activeStatus: activeStatus
            },
            function (data) { //controller response
                console.log(data);
            }
        );
    });
});