<div class="card">
    <div class="card-header">
        <a href="index.php?act=carrent&pg=carrent_add" class="btn btn-primary"><i class="fas fa-plus"></i> เพิ่มข้อมูล</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover text-nowrap" id="hotelTable">
                <thead>
                    <tr>
                        <th class="text-center">ลำดับ</th>
                        <th class="text-left">รูปภาพ</th>
                        <th class="text-left">ผู้ให้บริการ</th>
                        <th class="text-center">โทรศัพท์</th>
                        <th class="text-left">สถานะใช้งาน</th>
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
    $(document).ready(function() {
        // Table
      $('#hotelTable').dataTable({
            "order": [
                [0, "asc"]
            ],
            columnDefs: [{
                    targets: 0,
                    className: 'align-middle text-center'
                },
                {
                    targets: 1,
                    className: 'align-middle text-left',
                    orderable: false
                },
                {
                    targets: 2,
                    className: 'align-middle'
                },
                {
                    targets: 3,
                    className: 'align-middle text-center',
                    orderable: false
                },
                {
                    targets: 4,
                    className: 'align-middle text-left',
                    orderable: false
                },
                {
                    targets: 5,
                    className: 'align-middle text-center',
                    orderable: false
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "admin_carrent/carrent_list_ajax.php",
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
                "sProcessing": "กำลังโหลด...",
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

    async function appChange(param1, param2, id) {
        if ($(`#${param1}`).prop("checked")) {
            $(`#${param2}`).text('อนุมัติ');
            try {
                const response = await axios.get(`admin_carrent/carrent_status_ajax.php?id=${id}&status=1`);
                $('#hotelTable').DataTable().ajax.reload();
                console.log(response.data);
            } catch (error) {
                console.error(error);
            }
        } else {
            $(`#${param2}`).text('รออนุมัติ');
            try {
                const response = await axios.get(`admin_carrent/carrent_status_ajax.php?id=${id}&status=2`);
                $('#hotelTable').DataTable().ajax.reload();
                console.log(response.data);
            } catch (error) {
                console.error(error);
            }
        }
    }
</script>