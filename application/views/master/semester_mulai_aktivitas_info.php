<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="semester_mulai_aktivitas">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Semester Mulai Aktivitas</th>
                <td><?= $semester_mulai_aktivitas ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>