<?php
/**
 * Created by IntelliJ IDEA.
 * User: daniele
 * Date: 27/01/2016
 * Time: 19:52
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * @ORM\Table
 * @ORM\Entity
 */
class PaymentToken extends Token
{
}