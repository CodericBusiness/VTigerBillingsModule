<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Invoice_Consign_Action extends Inventory_Save_Action {

    public function saveRecord($request) {
        $recordModel = $this->getRecordModelFromRequest($request);
        $recordId = $request->get('record');
        
                
        $json = getJsonInvoice($recordId, $recordModel->getProducts());
        
        $resolution = $request->get('resolution');
        $prefix = $request->get('prefix');
        
        $serial = $recordModel->getSerial($resolution, $prefix);
        $json["number"] = $serial;
        $json["prefix"] = $prefix;
        $json["resolution_number"] = $resolution;
        print_r($recordModel);
   
        $result = $recordModel->affectDian($json);

        if ($result->status == "success") {
            $recordModel->consignInvoice($recordModel->getId(),$resolution, $prefix);
        } else {
            print_r($result);
        }
                
        $this->savedRecordId = $recordModel->getId();
        //Reverting the action value to $_REQUEST
        $_REQUEST['action'] = $request->get('action');
                
		return $recordModel;
			}
        
    private function getSerial($id) {
        
        global $log;
        global $adb;
        global $theme, $current_user;
    }
        
    }
