<?php

namespace App\Controller;

use App\Repository\FormulaireRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;


class DompdfController extends AbstractController
{
    /**
     * @Route("/dompdf", name="dompdf")
     */
    public function index(FormulaireRepository $formulaire)
    {
        // configure Dompdf with option 

        $repository = $formulaire->findAll();

        // dump($repository);die;

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

         $html = $this->renderView('dompdf/mypdf.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // render the html as PDF 
        $dompdf->render();

        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
}
