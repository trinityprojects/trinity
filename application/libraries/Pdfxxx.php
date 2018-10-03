<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Chris Harvey
 * @license			MIT License
 * @link			https://github.com/chrisnharvey/CodeIgniter-PDF-Generator-Library
 */

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf
{
	/**
	 * Get an instance of CodeIgniter
	 *
	 * @access	protected
	 * @return	void
	 */
	public function _construct()
	{
		parent::_construct();
	}

	protected function ci()
	{
		return get_instance();
	}	
	public function load_view($view, $data = array())
	{
		$dompdf = new Dompdf();
		$html = $this->ci()->load->view($view, $data, TRUE);

		$dompdf->loadHtml($html);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');

		// Render the HTML as PDF
		$dompdf->render();
		$time = time();

		// Output the generated PDF to Browser
		$dompdf->stream("welcome.pdf");
	}	
	
	
}