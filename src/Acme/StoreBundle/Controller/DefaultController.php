<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

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
        $doctrine = $this->getDoctrine();
        pre(get_class($doctrine));
        $em = $this->getDoctrine()->getManager();
        echo get_class($em);
        $products = $em->getRepository('AcmeStoreBundle:Product')->findAll();
        pre($products,'$products');
        return new Response();
    }
}
