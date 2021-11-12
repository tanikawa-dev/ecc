<?php
declare(strict_types=1);

namespace Xiuchuan\Ecc\Serializer\PublicKey;

use Xiuchuan\Ecc\Crypto\Key\PublicKeyInterface;
use Xiuchuan\Ecc\Math\GmpMathInterface;
use Xiuchuan\Ecc\Math\MathAdapterFactory;
use Xiuchuan\Ecc\Serializer\Point\PointSerializerInterface;
use Xiuchuan\Ecc\Serializer\Point\UncompressedPointSerializer;
use Xiuchuan\Ecc\Serializer\PublicKey\Der\Formatter;
use Xiuchuan\Ecc\Serializer\PublicKey\Der\Parser;

/**
 *
 * @link https://tools.ietf.org/html/rfc5480#page-3
 * @todo: review for full spec, should we support all prefixes here?
 */
class DerPublicKeySerializer implements PublicKeySerializerInterface
{

    const X509_ECDSA_OID = '1.2.840.10045.2.1';

    /**
     *
     * @var GmpMathInterface
     */
    private $adapter;

    /**
     *
     * @var Formatter
     */
    private $formatter;

    /**
     *
     * @var Parser
     */
    private $parser;

    /**
     * @param GmpMathInterface|null $adapter
     * @param PointSerializerInterface|null $pointSerializer
     */
    public function __construct(GmpMathInterface $adapter = null, PointSerializerInterface $pointSerializer = null)
    {
        $this->adapter = $adapter ?: MathAdapterFactory::getAdapter();

        $this->formatter = new Formatter();
        $this->parser = new Parser($this->adapter, $pointSerializer ?: new UncompressedPointSerializer());
    }

    /**
     *
     * @param  PublicKeyInterface $key
     * @return string
     */
    public function serialize(PublicKeyInterface $key): string
    {
        return $this->formatter->format($key);
    }

    /**
     * @param PublicKeyInterface $key
     * @return string
     */
    public function getUncompressedKey(PublicKeyInterface $key): string
    {
        return $this->formatter->encodePoint($key->getPoint());
    }

    /**
     * {@inheritDoc}
     * @see \Xiuchuan\Ecc\Serializer\PublicKey\PublicKeySerializerInterface::parse()
     */
    public function parse(string $string): PublicKeyInterface
    {
        return $this->parser->parse($string);
    }
}
