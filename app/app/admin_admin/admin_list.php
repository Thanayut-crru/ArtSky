<div class="card">
    <div class="card-header">
        <a href="index.php?act=admin&pg=admin_add" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มข้อมูล</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover text-nowrap" id="table-admin">
                <thead>
                    <tr>
                        <th class="text-center">รหัส</th>
                        <th class="text-left">ชื่อ-นามสกุล</th>
                        <th class="text-left">ชื่อผู้ใช้</th>
                        <th class="text-left">ประเภท</th>
                        <th class="text-left">สถานะ</th>
                        <th class="text-center">ตัวจัดการ</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="card-footer">
        &nbsp;
    </div>
</div>
<script>
    /*  Data Table Admin Ajax */
    $(document).ready(function() {
        // Table
        $('#table-admin').dataTable({
            "order": [
                [0, "asc"]
            ],
            columnDefs: [
                {
                    targets: 0,
                    className: 'align-middle text-center'
                },
                {
                    targets: 1,
                    className: 'align-middle'
                },
                {
                    targets: 2,
                    className: 'align-middle'
                },
                {
                    targets: 3,
                    className: 'align-middle text-left'
                },
                {
                    targets: 4,
                    className: 'align-middle text-center'
                },
                {
                    targets: 5,
                    className: 'align-middle text-center',
                    orderable: false
                },

            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "admin_admin/admin_ajax.php",
                "type": "POST"
            },
            // Thai lang
            "oLanguage": {
                "sEmptyTable": "ไม่มีข้อมูลในตาราง",
                "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "แสดง _MENU_ แถว",
                "sLoadingRecords": "กำลังโหลดข้อมูล...",
                "sProcessing": "กำลังดำเนินการ...",
                "sSearch": "ค้นหา: ",
                "sZeroRecords": "ไม่พบข้อมูล",
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "หน้าสุดท้าย"
                },
                "oAria": {
                    "sSortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
                    "sSortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
                }
            }
        });
    });
</script>