<?php

namespace App\Controller;

use App\Entity\WorkoutPlan;
use App\Form\WorkoutPlanType;
use App\Repository\WorkoutPlanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('admin/dashboard/workoutplan')]
final class WorkoutPlanController extends AbstractController
{
    #[Route(name: 'app_workout_plan_index', methods: ['GET'])]
    public function index(WorkoutPlanRepository $workoutPlanRepository): Response
    {
        return $this->render('workout_plan/index.html.twig', [
            'workout_plans' => $workoutPlanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_workout_plan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workoutPlan = new WorkoutPlan();
        $form = $this->createForm(WorkoutPlanType::class, $workoutPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workoutPlan);
            $entityManager->flush();

            return $this->redirectToRoute('app_workout_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('workout_plan/new.html.twig', [
            'workout_plan' => $workoutPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_workout_plan_show', methods: ['GET'])]
    public function show(WorkoutPlan $workoutPlan): Response
    {
        return $this->render('workout_plan/show.html.twig', [
            'workout_plan' => $workoutPlan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_workout_plan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkoutPlan $workoutPlan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkoutPlanType::class, $workoutPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_workout_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('workout_plan/edit.html.twig', [
            'workout_plan' => $workoutPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_workout_plan_delete', methods: ['POST'])]
    public function delete(Request $request, WorkoutPlan $workoutPlan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workoutPlan->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($workoutPlan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_workout_plan_index', [], Response::HTTP_SEE_OTHER);
    }
    /*
        #[Route('/{id}/join', name: 'workout_plan_join')]
        public function join(WorkoutPlan $workoutPlan, UserInterface $user, EntityManagerInterface $entityManager): Response
        {
            if (!$user->getPlans()->contains($workoutPlan)) {
                $user->addPlan($workoutPlan);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'You have joined the workout plan!');
            } else {
                $this->addFlash('info', 'You are already part of this plan.');
            }

            return $this->redirectToRoute('app_workout_plan_show', ['id' => $workoutPlan->getId()]);
        }
    */
}
