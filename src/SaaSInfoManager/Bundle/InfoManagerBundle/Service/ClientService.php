<?php

namespace SaaSInfoManager\Bundle\InfoManagerBundle\Service;

use SaaSInfoManager\Bundle\InfoManagerBundle\Entity\SearchParamObject;

class ClientService {

    /**
     * 
     * @param \SaaSInfoManager\Bundle\InfoManagerBundle\Entity\SearchParamObject $searchParams
     * @return array
     */
    public function getClientList(SearchParamObject $searchParams = null) {
        return array(1, 2, 3);
    }

}
