<?php
declare(strict_types=1);

# ������� �������� ���������� �������� � ���� � ������. ���������� �����������, ��� ��� ��������
function countPasswordSymbolsAndDigits(
    string $text,
    int    &$digitsCount,
    int    &$lettersCount,
    int    &$uppercaseSymbolsCount,
    int    &$lowercaseSymbolsCount,
    int    &$repeatedSymbolsCount,
): void
{
    foreach (str_split($text) as $char) {
        if (ctype_digit($char)) {
            $digitsCount++;
        } else {
            $lettersCount++;
            if (ctype_upper($char)) {
                $uppercaseSymbolsCount++;
            } else {
                $lowercaseSymbolsCount++;
            }
        }
        if (isset($allSymbols[$char])) {
            $repeatedSymbolsCount += 2;
        } else {
            $allSymbols[$char] = true;
        }
    }
}

function checkPasswordStrength(
    int $passwordLength,
    int $digitsCount,
    int $uppercaseSymbolsCount,
    int $lowercaseSymbolsCount,
    int $lettersCount,
    int $repeatedSymbolsCount
): int
{
 $Strength = 4 * $passwordLength;
 $Strength += 4 * $digitsCount;
 if ($uppercaseSymbolsCount != 0)
  $Strength += ($passwordLength - $uppercaseSymbolsCount)* 2;
 if ($lowercaseSymbolsCount != 0)
  $Strength += ($passwordLength - $lowercaseSymbolsCount)* 2;
    if($digitsCount == 0 || $lettersCount == 0)
  $Strength -= $passwordLength;
 $Strength -= $repeatedSymbolsCount;
    return $Strength;
}

# ��������� ������ ����� GET-������
$text = $_GET['text'];
if (empty($text)) {
    exit('Empty input!');
}

# ��� ���������� �������� �������� �� ������� ������ �������� � ������
# ������ ������ �������� ������ �� ���������� �������� � ������� � ������ ���������, � ����� �� ����

$passwordLength = strlen($text);

$allSymbols = array();
$digitsCount = 0;
$lettersCount = 0;
$uppercaseSymbolsCount = 0;
$lowercaseSymbolsCount = 0;
$repeatedSymbolsCount = 0;

countPasswordSymbolsAndDigits(
    $text,
    $digitsCount,
    $lettersCount,
    $uppercaseSymbolsCount,
    $lowercaseSymbolsCount,
    $repeatedSymbolsCount
);

$passwordStrength = checkPasswordStrength(
    $passwordLength,
    $digitsCount,
    $lettersCount,
    $uppercaseSymbolsCount,
    $lowercaseSymbolsCount,
    $repeatedSymbolsCount
);

echo('Strength of your password = ' . $passwordStrength);