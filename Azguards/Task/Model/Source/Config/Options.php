<?php
/**
 * Created By : Lokesh Pawar
 */

declare(strict_types=1);

namespace Azguards\Task\Model\Source\Config;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Options extends AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions(): array
    {
        $this->_options = [
            ['label' => '', 'value' => '0'],
            ['label' => 'Standard', 'value' => '1'],
            ['label' => 'Custom', 'value' => '2']
        ];
        return $this->_options;
    }
}