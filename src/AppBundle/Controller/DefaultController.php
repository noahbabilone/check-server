<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $filepath = $this->container->getParameter('kernel.root_dir') . '/../web/log/check.log';

        if (!file_exists($filepath)) {
            $this->setFlash("custom-alerts alert alert-danger fade in",
                '<i class="fa fa-warning"></i> <strong>Aucun</strong> de log trouvé.');
            return $this->redirectToRoute('homepage');
        }
        $logs = array();

        if (($handle = fopen($filepath, 'r')) !== false) {
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
//                    $logs  = explode("\r", $line);
                    $logs[] = $logs;
                }
                if (!feof($handle)) {
                    $this->setFlash("custom-alerts alert alert-danger fade in",
                        '<i class="fa fa-warning"></i> <strong>Erreur:</strong> fgets() a échoué\n.');
                    return $this->redirectToRoute('homepage');
                }
            } else {
                $this->setFlash("custom-alerts alert alert-danger fade in",
                    '<i class="fa fa-warning"></i> <strong>Error:</strong> opening the file.');
                return $this->redirectToRoute('homepage');
            }
        } else {
            $this->setFlash("custom-alerts alert alert-danger fade in",
                '<i class="fa fa-warning"></i> <strong>Error:</strong> opening the file.');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('default/index.html.twig', [
            "logs" => $logs

        ]);
    }
}
