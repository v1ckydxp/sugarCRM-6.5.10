<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


require_once('modules/DynamicFields/templates/Fields/TemplateCurrencyId.php');
require_once('modules/DynamicFields/templates/Fields/TemplateRange.php');

class TemplateCurrency extends TemplateRange
{
    var $max_size = 25;
    var $len = 26 ;
    var $precision = 6;
    var $type='currency';

    function delete($df){
    	parent::delete($df);
    	//currency id
    	$currency_id = new TemplateCurrencyId();
    	$currency_id->name = 'currency_id';
    	$currency_id->delete($df);
    }

    function save($df){
    	//the currency field
		$this->default = unformat_number($this->default);
		$this->default_value = $this->default;
    	parent::save($df);

    	//currency id
    	$currency_id = new TemplateCurrencyId();
    	$currency_id->name = 'currency_id';
    	$currency_id->vname = 'LBL_CURRENCY';
    	$currency_id->label = $currency_id->vname;
    	$currency_id->save($df);
    	//$df->addLabel($currency_id->vname);
    }

    function get_field_def(){
    	$def = parent::get_field_def();
		$def['precision'] = (!empty($this->precision)) ? $this->precision : 6;
    	return $def;
    }

	function get_db_type()
	{
		$precision = (!empty($this->precision)) ? $this->precision : 6;
		$len = (!empty($this->len)) ? $this->len:26;
		return " ".sprintf($GLOBALS['db']->getColumnType("decimal_tpl"), $len, $precision); 
	}
}