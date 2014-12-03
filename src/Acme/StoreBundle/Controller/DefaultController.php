<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Entity\Product;
use Acme\StoreBundle\Entity\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;

use \ReflectionClass as ReflectionClass;

/**
 * Class DefaultController
 *
 * @package Acme\StoreBundle\Controller
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        $product = new Product();
        $product->setName('candy baaar');
        $product->setPrice(12.22);
        $product->setDescription('This is a really cool product!');

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('name' => 'Samir'));
    }

    public function findAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product')
            ->findBy(
                array(
                    'name' => 'candy baaar'
                )
            );

        if (!$product) {
            throw $this->createNotFoundException('No product found for ' . $id);
        }

        $response = new Response();
        $return = '<pre>';
        $return .= print_r($product, true);
        $return .= '</pre>';
        $response->setContent($return);
        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('product' => $product));
    }

    public function complexFindAction()
    {
        /** @var EntityRepository $ProductRepository */
        $ProductRepository = $this->getDoctrine()->getRepository('AcmeStoreBundle:Product');

        /** @var QueryBuilder $QueryBuilder */
        $QueryBuilder = $ProductRepository->createQueryBuilder('p');

        /** @var Query $query */
        $Query = $QueryBuilder->where('p.price > :price')
            ->setParameter('price', '1')
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        /** @var Product[] $products */
        $Products = $Query->getResult();

        foreach ($Products as $Product) {
            pre($Product);
        }

        return new Response();
    }

    public function useRepositoryAction()
    {
        /** @var ProductRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository('AcmeStoreBundle:Product');
        $products = $repo->findAllOrderByName();
        pre($products);

//        /** @var Registry $doctrine */
//        $doctrine = $this->getDoctrine();
//
//        /** @var EntityManager $em */
//        $em = $doctrine->getManager();
//
//        /** @var Product[] $products */
//        $products = $em->getRepository('AcmeStoreBundle:Product')->findAll();
//
//        foreach($products as $product){
//            $reflection = new ReflectionClass($product);
//            pre($product, $reflection->getName().' ('.$reflection->getShortName().')');
//        }

        return new Response();
    }
}