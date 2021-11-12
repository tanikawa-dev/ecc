<?php
declare(strict_types=1);

namespace Xiuchuan\Ecc\Serializer\Point;

use Xiuchuan\Ecc\Primitives\PointInterface;
use Xiuchuan\Ecc\Primitives\CurveFpInterface;

interface PointSerializerInterface
{
    /**
     *
     * @param  PointInterface $point
     * @return string
     */
    public function serialize(PointInterface $point): string;

    /**
     * @param  CurveFpInterface $curve  Curve that contains the serialized point
     * @param  string           $string
     * @return PointInterface
     */
    public function unserialize(CurveFpInterface $curve, string $string): PointInterface;
}
