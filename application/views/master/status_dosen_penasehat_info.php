<?php
$this->load->view('_shared/header');
$this->load->view('_shared/menus');
//label
$control_label = array(
    'class' => 'control-label'
);
?>
<div class="container-full form-horizontal" id="status_dosen_penasehat">
    <table cellspacing="0" cellpadding="0" border="0" class="table table-bordered span4">
        <tbody>
            <tr>
                <th class="span2">Status Dosen Penasehat</th>
                <td><?= $status_dosen_penasehat ?></td>
            </tr>
        </tbody>
    </table>
</div>

<?php $this->load->view('_shared/footer'); ?>