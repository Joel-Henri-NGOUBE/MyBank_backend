<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Operations;
use App\Entity\Type;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CreateOperationController extends AbstractController
{
    public function __invoke($user_id, Request $request, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $payload = $request->getPayload()->all();
        $newOperation = new Operations();
        $newOperation->setLabel($payload['label']);
        $newOperation->setCategory(associateCategory($payload['category']));
        $newOperation->setType(associateType($payload['type']));
        $newOperation->setAmount($payload['amount']);
        $userRepository->findOneByIdField($user_id)->addOperation($newOperation);
        $em->persist($newOperation);
        $em->flush();

        return $this->json([
            'message' => 'Operation created',
        ]);

    }
}

function associateCategory($string)
{
    switch ($string) {
        case 'TAX':
            return Category::Tax;
        case 'SUBSCRIPTION':
            return Category::Subscription;
        case 'PAYMENT':
            return Category::Payment;
        case 'COURSES':
            return Category::Courses;
        case 'SALARY':
            return Category::Salary;
        case 'ALLOCATION':
            return Category::Allocation;
        case 'AUTOMOTO':
            return Category::AutoMoto;
        case 'DEPOSIT':
            return Category::Deposit;
        case 'WITHDRAWAL':
            return Category::Withdrawal;
        case 'CHEQUE':
            return Category::Cheque;
        case 'LOAN':
            return Category::Loan;
        case 'HOUSING':
            return Category::Housing;
        case 'ALIMONY':
            return Category::Alimony;
        case 'REFUND':
            return Category::Refund;
        case 'HEALTH':
            return Category::Health;
        case 'TRANSFER ISSUED':
            return Category::Transfer_issued;
        case 'TRANSFER RECEIVED':
            return Category::Transfer_received;
        case 'TRANSPORT':
            return Category::Transport;
        case 'GIFT':
            return Category::Gift;
        case 'EDUCATION':
            return Category::Education;
        case 'LEISURE':
            return Category::Leisure;
        case 'SAVING':
            return Category::Saving;
    }

}

function associateType($string)
{
    switch ($string) {
        case 'INCOME':
            return Type::Income;
        case 'EXPENSE':
            return Type::Expense;
    }
}
