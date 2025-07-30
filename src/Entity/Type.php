<?php

namespace App\Entity;

enum Type: string{
    case Income = "INCOME";
    case Expense = "EXPENSE";
}
