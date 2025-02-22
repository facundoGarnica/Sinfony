<?php

namespace App\Controller;
use App\Entity\Pedido;
use App\Entity\DetallePedido;
use App\Form\DetallePedidoType;
use App\Repository\DetallePedidoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/detalle/pedido')]
class DetallePedidoController extends AbstractController
{
    #[Route('/', name: 'app_detalle_pedido_index', methods: ['GET'])]
    public function index(DetallePedidoRepository $detallePedidoRepository): Response
    {
        return $this->render('detalle_pedido/index.html.twig', [
            'detalle_pedidos' => $detallePedidoRepository->findAll(),
        ]);
    }

    #[Route('/new/{idPedido}', name: 'app_detalle_pedido_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, $idPedido): Response
    {
        // Obtener el pedido usando el id proporcionado
        $pedido = $entityManager->getRepository(Pedido::class)->find($idPedido);

        if (!$pedido) {
            throw $this->createNotFoundException('Pedido no encontrado');
        }

        // Crear nuevo detalle de pedido
        $detallePedido = new DetallePedido();
        $detallePedido->setIdPedido($pedido); // Asigna el pedido automáticamente

        // Crear el formulario
        $form = $this->createForm(DetallePedidoType::class, $detallePedido);
        $form->handleRequest($request);

        // Verificar si el formulario se ha enviado y es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // Persistir el detalle de pedido
            $entityManager->persist($detallePedido);
            $entityManager->flush();

            return $this->redirectToRoute('app_detalle_pedido_index', [], Response::HTTP_SEE_OTHER);
        }

        // Renderizar el formulario
        return $this->renderForm('detalle_pedido/new.html.twig', [
            'detalle_pedido' => $detallePedido,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detalle_pedido_show', methods: ['GET'])]
    public function show(DetallePedido $detallePedido): Response
    {
        return $this->render('detalle_pedido/show.html.twig', [
            'detalle_pedido' => $detallePedido,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_detalle_pedido_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DetallePedido $detallePedido, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DetallePedidoType::class, $detallePedido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_detalle_pedido_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('detalle_pedido/edit.html.twig', [
            'detalle_pedido' => $detallePedido,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_detalle_pedido_delete', methods: ['POST'])]
    public function delete(Request $request, DetallePedido $detallePedido, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $detallePedido->getId(), $request->request->get('_token'))) {
            $entityManager->remove($detallePedido);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_detalle_pedido_index', [], Response::HTTP_SEE_OTHER);
    }
}
