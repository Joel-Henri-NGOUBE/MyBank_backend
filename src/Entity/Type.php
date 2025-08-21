<?php

namespace App\Entity;

/**
 * Defines the Enum class Type that will be used to type the Type field
 */

enum Type: string
{
    case Income = 'INCOME';
    case Expense = 'EXPENSE';
}
