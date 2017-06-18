<?php/** * Created by PhpStorm. * User: anthony-dev * Date: 19/01/17 * Time: 11:51 */namespace AppBundle\Service;use Symfony\Component\Console\Output\OutputInterface;use Symfony\Component\DependencyInjection\ContainerAwareInterface;use Symfony\Component\DependencyInjection\ContainerAwareTrait;use Symfony\Component\DependencyInjection\ContainerInterface;use Doctrine\ORM\EntityManager;class ServiceCheck{    public $container;    public $urls;    public function __construct(ContainerInterface $container)    {        $this->container = $container;        $this->urls = array(            array('url' => '10.0.2.33 ', 'msg' => 'DR'),            array('url' => '10.0.2.6 ', 'msg' => 'LVS 1'),            array('url' => '10.0.2.9 ', 'msg' => 'LVS 2'),            array('url' => '10.0.2.14 ', 'msg' => 'SERVER 1'),            array('url' => '10.0.2.7', 'msg' => 'SERVER'),//            array('url' => '10.0.2.33', 'msg' => 'SERVER'),        );    }    /**     * @param OutputInterface $output     */    public function test(OutputInterface $output)    {        foreach ($this->urls as $item) {            $result = $this->container->get('app.url.check')->testUrl($item["url"]);            $codeCurl = ($result !== null) ? $result['code'] : "200";            $date = new \DateTime();            $date->setTimezone(new \DateTimeZone("Europe/Paris"));            $output->writeln('[' . $date->format('d/m/Y H:i:s') . '] Code: ' . $codeCurl . ' - Url : ' . $item['url']);        }    }        private function getUrl()    {        $filepath = $this->container->getParameter('kernel . root_dir') . ' /../web / test . csv';        if (!file_exists($filepath))            return [];        $url = array();        if (($handle = fopen($filepath, 'r')) !== false) {            while (($data = fgetcsv($handle, 0, ';')) !== false) {                $url[] = array(                    'url' => $data[0],                    'msg' => $data[1],                );            }            fclose($handle);        }        return $url;    }}