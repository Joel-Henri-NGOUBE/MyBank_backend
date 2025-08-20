<?php

namespace App\Entity;

/**
 * Defines the Enum class Category that will be used to type the Category field
 */

enum Category: string{
    case Tax = "TAX";
    case Subscription = "SUBSCRIPTION";
    case Payment = "PAYMENT";
    case Courses = "COURSES";
    case Salary = "SALARY";
    case Allocation = "ALLOCATION";
    case AutoMoto = "AUTOMOTO";
    case Deposit = "DEPOSIT";
    case Withdrawal = "WITHDRAWAL";
    case Cheque = "CHEQUE";
    case Loan = "LOAN";
    case Housing = "HOUSING";
    case Alimony = "ALIMONY";
    case Refund = "REFUND";
    case Health = "HEALTH";
    case Transfer_issued = "TRANSFER ISSUED";
    case Transfer_received = "TRANSFER RECEIVED";
    case Transport = "TRANSPORT";
    case Gift = "GIFT";
    case Education = "EDUCATION";
    case Leisure = "LEISURE";
    case Saving = "SAVING";
}

