<?php

namespace App\Controller;

use App\Service\MessageGenerator;
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
    public function index(FormulaireRepository $formulaire, MessageGenerator $messageGenerator)

    {

        $message = $messageGenerator->getHappyMessage();
        // configure Dompdf with option 
        // donnee repository 



        $repository = $formulaire->findAll();

        // dump($repository);die;

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

         $html = $this->renderView('dompdf/mypdf.html.twig', [
            'dodos' => $repository,
            'title' => "the best",
            'message' => $message,
            'Roro' => $messageGenerator->getDodo()
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
