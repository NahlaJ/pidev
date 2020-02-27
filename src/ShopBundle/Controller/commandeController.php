<?php

namespace ShopBundle\Controller;

use CatalogueBundle\Entity\Produit;
use ShopBundle\Entity\Commande;
use ShopBundle\Entity\LigneCommande;
use ShopBundle\Entity\Livreur;
use Knp\Snappy\Pdf;
use ShopBundle\Repository\ProduitRepository;
//use Stripe\Error\Card;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use ShopBundle\Repository\commandeRepository ;
use Symfony\Component\PropertyAccess\PropertyAccess;


class commandeController extends Controller
{

    public function ajouterAction($id , SessionInterface $session)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $panier=$session->get('panier', []);
            if(!empty($panier[$id])){
                $panier[$id]++;
            }
            else
                $panier[$id]=1 ;
            $session->set('panier', $panier);
            $panierWithData=[] ;
           // var_dump($panier);




            foreach ( $panier as $id => $quantity) {

                $product=$this->getDoctrine()->getRepository(Produit::class)->find($id);
                $panierWithData[]=[
                    'product'=>$product,
                    'quantity'=>$quantity ,
                ];
                // var_dump($panierWithData);

            }
      //      var_dump($panierWithData );
            $total=0 ;
            foreach ($panierWithData as $item){
                if($item['product']->getPromo() != null ) {
                    $totalItem = $item['product']->getPromo()->getNewPrix() * $item['quantity'];
                }
                else
                {
                    $totalItem = $item['product']->getPrix() * $item['quantity'];

                }
                $total += $totalItem;
            }
            return $this->render('@Shop/commande/panier.html.twig', ['items'=> $panierWithData  ,
                'total'=>$total,
                'user'=>$user,
            ]) ;


        }
  else
        return $this->redirectToRoute('fos_user_security_login');



        /*if(!$session->has('panier')) $session->set('panier',array());
        $panier=$session->get('panier') ;
        if(array_key_exists($id , $panier  )) {
            if ($this->getRequest()->query->get('qte') != null) $panier['$id'] = $this->getRequest()->query->get('qte');
        } else {
            if($this->getRequest()->query->get('qte')!=null)
                $panier[$id]=$this->getRequest()->query->get('qte');
            else
                $panier[$id] = 1 ;
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('panier');*/
    }

    public function LessAction($id , SessionInterface $session)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $panier=$session->get('panier', []);
            if(!empty($panier[$id])){
                $panier[$id]--;
            }
            else
                $panier[$id]=1 ;

            $session->set('panier', $panier);
            $panierWithData=[] ;
            // var_dump($panier);




            foreach ( $panier as $id => $quantity) {

                $product=$this->getDoctrine()->getRepository(Produit::class)->find($id);
                $panierWithData[]=[
                    'product'=>$product,
                    'quantity'=>$quantity ,
                ];
                // var_dump($panierWithData);

            }
            //      var_dump($panierWithData );
            $total=0 ;
            foreach ($panierWithData as $item){
                if($item['product']->getPromo() != null ) {
                    $totalItem = $item['product']->getPromo()->getNewPrix() * $item['quantity'];
                }
                else
                {
                    $totalItem = $item['product']->getPrix() * $item['quantity'];

                }
                $total += $totalItem;
            }
            return $this->render('@Shop/commande/panier.html.twig', ['items'=> $panierWithData  ,
                'total'=>$total,
                'user'=>$user,
            ]) ;


        }
        else
            return $this->redirectToRoute('fos_user_security_login');



        /*if(!$session->has('panier')) $session->set('panier',array());
        $panier=$session->get('panier') ;
        if(array_key_exists($id , $panier  )) {
            if ($this->getRequest()->query->get('qte') != null) $panier['$id'] = $this->getRequest()->query->get('qte');
        } else {
            if($this->getRequest()->query->get('qte')!=null)
                $panier[$id]=$this->getRequest()->query->get('qte');
            else
                $panier[$id] = 1 ;
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('panier');*/
    }


    public function viderPanierAction(SessionInterface $session)
    {  if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $panier = $session->get('panier', []);
        $panier = $session->clear();
        $items = [];
        $totale=0 ;
        return $this->render('@Shop/commande/panier.html.twig', ['items' => $items, 'user' => $user ,'total'=>$totale]);
    }
    }



    public function showPanierAction(SessionInterface $session )
    {
        $panier=$session->get('panier' , []) ;
        $panierWithData=[] ;
      //  var_dump($panier);




        foreach ( $panier as $id => $quantity) {

            $product=$this->getDoctrine()->getRepository(Produit::class)->find($id);
            $panierWithData[]=[
                'product'=>$product,
                'quantity'=>$quantity ,
            ];
           // var_dump($panierWithData);

        }

        $total=0 ;
        foreach ($panierWithData as $item){
            if($item['product']->getPromo() != null ) {
                $totalItem = $item['product']->getPromo()->getNewPrix() * $item['quantity'];
            }
            else
            {
                $totalItem = $item['product']->getPrix() * $item['quantity'];

            }
        }
        return $this->render('@Shop/commande/panier.html.twig', ['items'=> $panierWithData  ,
            'total'=>$total,
        ]) ;

    }

    public function supprimerAction($id , SessionInterface $session)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $panier = $session->get('panier', []);
            if (!empty($panier[$id])) {
                unset($panier[$id]);
            }
            $session->set('panier', $panier);
            $panierWithData = [];
            // var_dump($panier);


            foreach ($panier as $id => $quantity) {

                $product = $this->getDoctrine()->getRepository(Produit::class)->find($id);
                $panierWithData[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
                // var_dump($panierWithData);

            }
            //      var_dump($panierWithData );
            $total = 0;
            foreach ($panierWithData as $item) {
                if($item['product']->getPromo() != null ) {
                    $totalItem = $item['product']->getPromo()->getNewPrix() * $item['quantity'];
                }
                else
                {
                    $totalItem = $item['product']->getPrix() * $item['quantity'];

                }

                $total += $totalItem;
            }
            return $this->render('@Shop/commande/panier.html.twig', ['items' => $panierWithData,
                'total' => $total,
                'user' => $user,
            ]);
        }
    }

    public function panierAction()
    {
        $session=$this->getRequest()->getSession() ;
        if(!$session->has('panier')) $session->set('panier',array())  ;
     //   var_dump($session->get('panier  '));

        return $this->render('@Shop/commande/panier.html.twig');
    }



    public function editAction(Request $request, commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('ShopBundle\Form\commandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('@Shop/commande/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function orderAction()
    {
        $panier=$this->get('session')->get('panier');
        $user=$this->get('session')->get('CUser');
        $em=$this->getDoctrine()->getManager();
        $commande=new Commande();
        $panierWithData=[] ;

        foreach ( $panier as $id => $quantity) {

            $product=$this->getDoctrine()->getRepository(Produit::class)->find($id);
            $panierWithData[]=[
                'product'=>$product,
                'quantity'=>$quantity ,
            ];
            // var_dump($panierWithData);

        }

        $total=0 ;
        foreach ($panierWithData as $item){
            if($item['product']->getPromo() != null ) {
                $totalItem = $item['product']->getPromo()->getNewPrix() * $item['quantity'];

            }
            else
            {
                $totalItem = $item['product']->getPrix() * $item['quantity'];

            }
            $total += $totalItem;

        }
        if(count($panier)>0 && $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
        {

            $commande->setDateCommande(new \DateTime());
            $commande->setStatus('nouvelle');
            $commande->setQuantite(0);

                $cuser = $this->container->get('security.token_storage')->getToken()->getUser();
                $commande->setUser($cuser);
                $commande->setTotale($total) ;


            $em->persist($commande);
            foreach ( $panier as $id => $quantity)
            {
                $orderLigne=new LigneCommande();
                $orderLigne->setCommande($commande);
                $produit=$this->getDoctrine()->getRepository(Produit::class)->find($id);
                $produit->setQuantite($produit->getQuantite()-$quantity['quantity']);
                $em->flush();
                $orderLigne->setProduit($produit);
                $orderLigne->setQuantite($quantity);
                $em->persist($orderLigne);
            }
            $em->flush();
            $commandeDetails=$this->getDoctrine()->getRepository(LigneCommande::class)->findBy(array(
                'commande'=>$commande
            ));


            $em->flush();
            $this->get('session')->set('Panier',array());
            $this->get('session')->set('CUser',array());
            $this->get('session')->set('total',0);
            $this->get('session')->set('prixfinal',0);

            $manager = $this->get('mgilet.notification');
            $notif = $manager->createNotification('Hello world!');
            $notif->setMessage('This a notification.');

            $manager->addNotification(array($this->getUser()), $notif, true);

            return $this->render('@Shop/commande/index.html.twig',['commande'=>$commandeDetails , 'user'=>$user]);

        }
        else
            return $this->redirectToRoute('login') ;

    }

    public function showCommandesAction(Request $request)
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $em=$this->getDoctrine()->getManager() ;
        $commandes=$em->getRepository(Commande::class)->findAll();

        $commandeDetails=$this->getDoctrine()->getRepository(LigneCommande::class)->findBy(array(
            'commande'=>$commandes
        ));



        return $this->render('@Shop/Admin/show_commandes.html.twig' , ['commandes'=>$commandes]) ;


            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    public function showInfosCommandeAction(Commande  $commande , Request $request )
    {
        $user = $this->getUser();
        if ($user != null) {
            if ($user->getRoles()[0] == 'ROLE_ADMIN') {
        $em = $this->getDoctrine()->getManager();


        $commandeDetails=$this->getDoctrine()->getRepository(LigneCommande::class)->findBy(array(
            'commande'=>$commande
        ));
        if ($commandeDetails[0]->getCommande()->getStatus() =='nouvelle') {
            $commande->setStatus('en cours');

            $em->flush();
        }


        $livreur=$em->getRepository(Livreur::class)->findByDisponibilte() ;


        if ($request->getMethod()=="POST" ) {

            $liv=$request->get('Livreur') ;

            $livreurAffecter=$em->getRepository('ShopBundle:Livreur')->findById($liv) ;


            $commande->setStatus("Livre");

            $commande->setLivreur($livreurAffecter[0]);
            $livreurAffecter[0]->setDisponibilite("non") ;
            $commandeDetails[0]->getCommande()->setStatus("Livre") ;
            $em->flush();

            return $this->redirectToRoute('show_commandes');

        }
        return $this->render('@Shop/Admin/show_info_commandes.html.twig', array(
            'commande' => $commandeDetails,
            'livreur'=>$livreur


        ));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    public function MesCommmandesAction(Request $request)
    {
        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $repo=$this->getDoctrine()->getRepository(Commande::class)->findBy(array(
                "user"=>$user
            ));

            if ($request->getMethod() == Request::METHOD_GET) {

                if ($request->get('TELECHARGER_PDF') == "TELECHARGER_PDF") {

                    $snappy = new Pdf('C:\wkhtmltopdf\bin\wkhtmltopdf');
                    $html = "<style>
          .clearfix:after {
  content: \"\";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}</style>
<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <title>Example 1</title>
    <link rel=\"stylesheet\" href=\"style.css\" media=\"all\" />
  </head>
  <body>
    <header class=\"clearfix\">
      <div id=\"logo\">
        <img src=\"logo.png\">
      </div>
      <h1> COMMANDE LIST</h1>
      <div id=\"company\" class=\"clearfix\">
        <div>Cycle.tn</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href=\"mailto:company@example.com\">cycle@gmail.com</a></div>
      </div>
      
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th>ID COMMANDE</th>          
            <th class=\"service\">STATUS COMMANDE</th>
            <th>QUANTITY</th>
            <th>PRICE</th>
          </tr>
        </thead>
        <tbody>";
                    foreach ($repo as $e) {
                        $html = $html . "<tr>
            <td class=\"qty\">" . $e->getId() . "</td>
            <td class=\"service\">" . $e->getStatus() . "</td>
            <td class=\"desc\">" . $e->getQuantite() . "</td>
            <td class=\"total\">" . $e->getTotale() . "</td>
          </tr>";

                    }
                    $html = $html . "
          
        </tbody>
      </table>
      <div id=\"notices\">
        <div>NOTICE:</div>
        <div class=\"notice\">HAVE A NICE DAY</div>
      </div>
    </main>
    <footer>
     CYCLE.TN
    </footer>
  </body>
</html>";
                    $snappy->generateFromHtml($html, '/tmp/commandes.pdf');


                }
            }
            return $this->render('@Shop/commande/mes_commandes.html.twig',array(
                'commandes'=>$repo
            ));
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    public function maCommandeAction(Commande $commande)
    {
        $em = $this->getDoctrine()->getManager();
        $commandeDetails=$this->getDoctrine()->getRepository(LigneCommande::class)->findBy(array(
            'commande'=>$commande
        ));

        return $this->render('@Shop/commande/Macommande.html.twig', array(
            'commande' => $commandeDetails,

        ));
    }

    public function stripeAction(Request $request)
    {
        $session=new Session();
        if($session->has('panier') )
        {
            if( count($session->get('panier'))>0)
            {
                return $this->render('@Shop/commande/stripe.html.twig');
            }
        }

        return $this->redirectToRoute('homepage');
    }

    public function stripePayAction()
    {
        $panier=$this->get('session')->get('panier');
        $panierWithData=[] ;

        foreach ( $panier as $id => $quantity) {

            $product=$this->getDoctrine()->getRepository(Produit::class)->find($id);
            $panierWithData[]=[
                'product'=>$product,
                'quantity'=>$quantity ,
            ];
            // var_dump($panierWithData);

        }
        $total=0 ;
        foreach ($panierWithData as $item){
            if($item['product']->getPromo() != null ) {
                $totalItem = $item['product']->getPromo()->getNewPrix() * $item['quantity'];

            }
            else
            {
                $totalItem = $item['product']->getPrix() * $item['quantity'];

            }
            $total += $totalItem;
        }
        header('Content-Type: application/json');
        $session=new Session();
        $stripe = new Stripe();
        $stripe->setApiKey('sk_test_BNSRHelInCooaOmJsgAvPShj00bHxIaAAv');
        //Stripe::setApiKey();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = file_get_contents('php://input');
            $body = json_decode($input);
        }
        $response=new JsonResponse();
        try {
            $array=get_object_vars($body);
            //var_dump($array);
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $paymenMethodId=$propertyAccessor->getValue($array, '[paymentMethodId]');

            $intent = PaymentIntent::create([
                "amount" => $total,
                "currency" => 'eur',
                "payment_method" => $paymenMethodId,
                "confirmation_method" => "manual",
                "confirm" => true,
            ]);
            $output = $this->generateResponse($intent);


            $response->setData($output);
            return $response;
        } catch (Card $e) {
            $response->setData(array(
                'error' => $e->getMessage()
            ));
            return $response;
        }
    }

    public function stripeKeyAction()
    {
        $response=new JsonResponse();
        $response->setData(array(
            'publishableKey' => 'pk_test_J4tl8I1aop13SJLMTv312uz300i1xn6O8S'
        ));
        return $response;
    }




}
