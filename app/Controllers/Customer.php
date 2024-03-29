<?php

namespace App\Controllers;

class Customer extends BaseController
{
    public function __construct()
    {
        $this->CustomerModel = new \App\Models\CustomerModel();
    }

    public function save($col, $id)
    {
        $this->db->query('update site_gamer set ' . $col . '=' . $this->db->escape($this->request->getVar('customerNote')) . " where id='" . $id . "'");

        $this->db->query("insert into logSys set
            `method`	='customer/save',
            `user_id`	='" . $this->session->get('primeId') . "',
            `data_id`	='" . $id . "',
            `dataNew`	=" . $this->db->escape($status . ' - ' . $col) . ",
            `timestamp` =NOW(),
            `ip` 		='" . getClientIpAddress() . "'
		");
    }

    public function switch($id, $col, $status)
    {
        $this->SecureModel->stateAuth(edit_customer);

        $this->db->query('update site_gamer set ' . $col . "='" . $status . "' where id='" . $id . "'");

        $this->db->query("insert into logSys set
            `method`	='customer/switch',
            `user_id`	='" . $this->session->get('primeId') . "',
            `data_id`	='" . $id . "',
            `dataNew`	=" . $this->db->escape($status . ' - ' . $col) . ",
            `timestamp` =NOW(),
            `ip` 		='" . getClientIpAddress() . "'
		");
    }

    public function index()
    {
        $this->SecureModel->stateAuth(view_customer);

        echo htmlMinify(view('app/customer/index'));
    }

    public function detail($id)
    {
        $this->SecureModel->stateAuth(view_customer);
        $data['customer'] = $this->CustomerModel->detail($id)->getRow();

        echo htmlMinify(view('app/customer/detail', $data));
    }

    public function include($fileName)
    {
        echo htmlMinify(view('app/customer/include/' . $fileName));
    }

    public function datatable()
    {
        $this->SecureModel->stateAuth(view_customer);

        $data['dataTable']    = $this->CustomerModel->datatable($this->request->getVar('start'), $this->request->getVar('length'), $_POST);
        $data['dataTableNum'] = count((array)$this->CustomerModel->datatable('', '', $_POST)->getResult());
        $data['length']       = intval($this->request->getVar('length'));
        $data['start']        = intval($this->request->getVar('start'));
        $data['draw']         = intval($this->request->getVar('draw'));
        $iTotalRecords        = $data['dataTableNum'];
        $iDisplayLength       = $data['length'];
        $iDisplayLength       = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart        = $data['start'];
        $sEcho                = $data['draw'];
        $records              = [];
        $records['data']      = [];
        $end                  = $iDisplayStart + $iDisplayLength;
        $end                  = $end > $iTotalRecords ? $iTotalRecords : $end;

        $i = 0;
        foreach ($data['dataTable']->getResult() as $row) {
            $isVip = $row->isVip == 'on' ? 'checked' : null;
            $deposit = $row->deposit == 'on' ? 'checked' : null;
            $withdraw = $row->withdraw == 'on' ? 'checked' : null;
            $records['data'][$i] = [
                'DT_RowId' => $row->id,
                '<a href="customer/detail/' . $row->id . '/' . $row->site_id . '/' . $row->gamer_site_id . '" class="d-flex align-items-center">
                    <div class="symbol symbol-circle symbol-40px overflow-hidden me-3">
                        <span class="symbol-label fs-6 bg-light text-dark">' . userNameShort($row->gamer_name) . '</span>
                    </div>
                    <span class="text-gray-800 text-hover-primary">' . $row->gamer_name . '</span>
				</a>',
                '<div class="text-start">' . $row->gamer_nick . '</div>',
                '<div class="text-center">' . $row->gamer_site_id . '</div>',
                '<div class="text-center">' . $row->clientName . '</div>',
                '<div class="text-center">' . ($row->totalProcess == '' || $row->totalProcess == 0 ? 'none' : $row->totalProcess . ' txn') . '</div>',
                '<div class="text-center">' . ($row->lastProcess == '' ? 'none' : $row->lastProcess) . '</div>',
                '<div class="flex-center form-check form-switch form-switch-sm form-check-success form-check-custom form-check-solid"><input type="checkbox" role="switch" id="isVip" data-set="switch" ' . (edit_customer !== true ? 'disabled' : null) . ' data-id="' . $row->id . '" name="isVip" class="form-check-input h-20px w-45px" ' . $isVip . '></div>',
                '<a href="customer/detail/' . $row->id . '/' . $row->site_id . '/' . $row->gamer_site_id . '" class="btn btn-sm btn-light btn-active-light-primary">View</a>'
            ];

            $i++;
        }

        if (isset($_REQUEST['customActionType']) && $_REQUEST['customActionType'] == 'group_action') {
            $records['customActionStatus'] = 'OK'; // pass custom message(useful for getting status of group actions)
            $records['customActionMessage'] = 'Group action successfully has been completed. Well done!'; // pass custom message(useful for getting status of group actions)
        }

        $records['draw'] = $sEcho;
        $records['recordsTotal'] = $iTotalRecords;
        $records['recordsFiltered'] = $iTotalRecords;

        echo json_encode($records);
    }
}