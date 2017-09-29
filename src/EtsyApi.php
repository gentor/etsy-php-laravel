<?php

namespace Gentor\Etsy;


use Gentor\Etsy\Exceptions\EtsyRequestException;
use Gentor\Etsy\Exceptions\EtsyResponseException;
use Gentor\Etsy\Helpers\RequestValidator;
use Gentor\OAuth1Etsy\Client\Server\Etsy;
use League\OAuth1\Client\Credentials\TokenCredentials;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Class EtsyApi
 * @package Gentor\Etsy
 *
 * All methods has only one argument, an array with two items (both are optional, depends on the method):
 * array('params' => array(), 'data' => array())
 * :params for uri params
 * :data for "post fields"
 *
 * @see https://www.etsy.com/developers/documentation
 *
 * @method array getMethodTable(array $argument = [])
 * @method array getPublicBaseline(array $argument = [])
 * @method array getCategory(array $argument = [])
 * @method array getSubCategory(array $argument = [])
 * @method array getSubSubCategory(array $argument = [])
 * @method array findAllCountry(array $argument = [])
 * @method array getCountry(array $argument = [])
 * @method array findByIsoCode(array $argument = [])
 * @method array findAllFeaturedTreasuries(array $argument = [])
 * @method array getFeaturedTreasuryById(array $argument = [])
 * @method array findAllListingsForFeaturedTreasuryId(array $argument = [])
 * @method array findAllActiveListingsForFeaturedTreasuryId(array $argument = [])
 * @method array findAllFeaturedListings(array $argument = [])
 * @method array findAllCurrentFeaturedListings(array $argument = [])
 * @method array findAllFeaturedTreasuriesByOwner(array $argument = [])
 * @method array getGuest(array $argument = [])
 * @method array findAllGuestCarts(array $argument = [])
 * @method array addToGuestCart(array $argument = [])
 * @method array updateGuestCartListingQuantity(array $argument = [])
 * @method array removeGuestCartListing(array $argument = [])
 * @method array findGuestCart(array $argument = [])
 * @method array updateGuestCart(array $argument = [])
 * @method array deleteGuestCart(array $argument = [])
 * @method array claimGuest(array $argument = [])
 * @method array mergeGuest(array $argument = [])
 * @method array generateGuest(array $argument = [])
 * @method array listImageTypes(array $argument = [])
 * @method array createListing(array $argument = [])
 * @method array getListing(array $argument = [])
 * @method array updateListing(array $argument = [])
 * @method array deleteListing(array $argument = [])
 * @method array getAttributes(array $argument = [])
 * @method array getAttribute(array $argument = [])
 * @method array updateAttribute(array $argument = [])
 * @method array deleteAttribute(array $argument = [])
 * @method array findAllListingFavoredBy(array $argument = [])
 * @method array findAllListingFiles(array $argument = [])
 * @method array uploadListingFile(array $argument = [])
 * @method array findListingFile(array $argument = [])
 * @method array deleteListingFile(array $argument = [])
 * @method array findAllListingFundOnEtsyCampaign(array $argument = [])
 * @method array findAllListingImages(array $argument = [])
 * @method array uploadListingImage(array $argument = [])
 * @method array getImage_Listing(array $argument = [])
 * @method array deleteListingImage(array $argument = [])
 * @method array getInventory(array $argument = [])
 * @method array updateInventory(array $argument = [])
 * @method array getProduct(array $argument = [])
 * @method array getOffering(array $argument = [])
 * @method array findAllListingShippingProfileEntries(array $argument = [])
 * @method array createShippingInfo(array $argument = [])
 * @method array getListingShippingUpgrades(array $argument = [])
 * @method array createListingShippingUpgrade(array $argument = [])
 * @method array updateListingShippingUpgrade(array $argument = [])
 * @method array deleteListingShippingUpgrade(array $argument = [])
 * @method array findAllListingTransactions(array $argument = [])
 * @method array getListingTranslation(array $argument = [])
 * @method array createListingTranslation(array $argument = [])
 * @method array updateListingTranslation(array $argument = [])
 * @method array deleteListingTranslation(array $argument = [])
 * @method array getListingVariations(array $argument = [])
 * @method array createListingVariations(array $argument = [])
 * @method array updateListingVariations(array $argument = [])
 * @method array createListingVariation(array $argument = [])
 * @method array updateListingVariation(array $argument = [])
 * @method array deleteListingVariation(array $argument = [])
 * @method array findAllListingActive(array $argument = [])
 * @method array getInterestingListings(array $argument = [])
 * @method array getTrendingListings(array $argument = [])
 * @method array pagesSignup(array $argument = [])
 * @method array findPage(array $argument = [])
 * @method array updatePageData(array $argument = [])
 * @method array uploadAvatar(array $argument = [])
 * @method array findAllPageCollections(array $argument = [])
 * @method array createPageCollection(array $argument = [])
 * @method array getPageCollection(array $argument = [])
 * @method array updatePageCollection(array $argument = [])
 * @method array deletePageCollection(array $argument = [])
 * @method array getCollectionListings(array $argument = [])
 * @method array addListingToCollection(array $argument = [])
 * @method array removeListingFromCollection(array $argument = [])
 * @method array findPageCollectionsForListings(array $argument = [])
 * @method array addCurator(array $argument = [])
 * @method array removeCurator(array $argument = [])
 * @method array curatorPeopleSearch(array $argument = [])
 * @method array findPayment(array $argument = [])
 * @method array findPaymentAdjustments(array $argument = [])
 * @method array findPaymentAdjustment(array $argument = [])
 * @method array findPaymentAdjustmentItem(array $argument = [])
 * @method array getPrivateBaseline(array $argument = [])
 * @method array getPropertyOptionModifier(array $argument = [])
 * @method array findAllSuggestedPropertyOptions(array $argument = [])
 * @method array findPropertySet(array $argument = [])
 * @method array getShop_Receipt2(array $argument = [])
 * @method array updateReceipt(array $argument = [])
 * @method array findAllReceiptListings(array $argument = [])
 * @method array findAllShop_Receipt2Transactions(array $argument = [])
 * @method array findAllRegion(array $argument = [])
 * @method array getRegion(array $argument = [])
 * @method array findEligibleRegions(array $argument = [])
 * @method array findBrowseSegments(array $argument = [])
 * @method array findBrowseSegmentListings(array $argument = [])
 * @method array findBrowseSegmentPosters(array $argument = [])
 * @method array getServerEpoch(array $argument = [])
 * @method array ping(array $argument = [])
 * @method array getShippingCosts(array $argument = [])
 * @method array getShippingInfo(array $argument = [])
 * @method array updateShippingInfo(array $argument = [])
 * @method array deleteShippingInfo(array $argument = [])
 * @method array getPostageRates(array $argument = [])
 * @method array createShippingTemplate(array $argument = [])
 * @method array getShippingTemplate(array $argument = [])
 * @method array updateShippingTemplate(array $argument = [])
 * @method array deleteShippingTemplate(array $argument = [])
 * @method array findAllShippingTemplateEntries(array $argument = [])
 * @method array findAllShippingTemplateUpgrades(array $argument = [])
 * @method array createShippingTemplateUpgrade(array $argument = [])
 * @method array updateShippingTemplateUpgrade(array $argument = [])
 * @method array deleteShippingTemplateUpgrade(array $argument = [])
 * @method array createShippingTemplateEntry(array $argument = [])
 * @method array getShippingTemplateEntry(array $argument = [])
 * @method array updateShippingTemplateEntry(array $argument = [])
 * @method array deleteShippingTemplateEntry(array $argument = [])
 * @method array findAllShops(array $argument = [])
 * @method array getShop(array $argument = [])
 * @method array updateShop(array $argument = [])
 * @method array getShopAbout(array $argument = [])
 * @method array uploadShopBanner(array $argument = [])
 * @method array deleteShopBanner(array $argument = [])
 * @method array findAllShopCoupons(array $argument = [])
 * @method array createCoupon(array $argument = [])
 * @method array findCoupon(array $argument = [])
 * @method array updateCoupon(array $argument = [])
 * @method array deleteCoupon(array $argument = [])
 * @method array findLedger(array $argument = [])
 * @method array findLedgerEntries(array $argument = [])
 * @method array findLedgerEntry(array $argument = [])
 * @method array findPaymentAdjustmentForLedgerEntry(array $argument = [])
 * @method array findPaymentForLedgerEntry(array $argument = [])
 * @method array findAllShopListingsActive(array $argument = [])
 * @method array findAllShopListingsDraft(array $argument = [])
 * @method array findAllShopListingsExpired(array $argument = [])
 * @method array getShopListingExpired(array $argument = [])
 * @method array findAllShopListingsFeatured(array $argument = [])
 * @method array findAllShopListingsInactive(array $argument = [])
 * @method array getShopListingInactive(array $argument = [])
 * @method array findShopPaymentTemplates(array $argument = [])
 * @method array createShopPaymentTemplate(array $argument = [])
 * @method array updateShopPaymentTemplate(array $argument = [])
 * @method array findAllShopReceipts(array $argument = [])
 * @method array findShopPaymentByReceipt(array $argument = [])
 * @method array submitTracking(array $argument = [])
 * @method array findAllShopReceiptsByStatus(array $argument = [])
 * @method array findAllOpenLocalDeliveryReceipts(array $argument = [])
 * @method array searchAllShopReceipts(array $argument = [])
 * @method array getShopReviews(array $argument = [])
 * @method array findAllShopSections(array $argument = [])
 * @method array createShopSection(array $argument = [])
 * @method array getShopSection(array $argument = [])
 * @method array updateShopSection(array $argument = [])
 * @method array deleteShopSection(array $argument = [])
 * @method array findAllShopSectionListings(array $argument = [])
 * @method array findAllShopSectionListingsActive(array $argument = [])
 * @method array getShopSectionTranslation(array $argument = [])
 * @method array createShopSectionTranslation(array $argument = [])
 * @method array updateShopSectionTranslation(array $argument = [])
 * @method array deleteShopSectionTranslation(array $argument = [])
 * @method array findAllShopTransactions(array $argument = [])
 * @method array getShopTranslation(array $argument = [])
 * @method array createShopTranslation(array $argument = [])
 * @method array updateShopTranslation(array $argument = [])
 * @method array deleteShopTranslation(array $argument = [])
 * @method array getListingShop(array $argument = [])
 * @method array getBuyerTaxonomy(array $argument = [])
 * @method array findAllTopCategory(array $argument = [])
 * @method array findAllTopCategoryChildren(array $argument = [])
 * @method array findAllSubCategoryChildren(array $argument = [])
 * @method array getTaxonomyNodeProperties(array $argument = [])
 * @method array getSellerTaxonomy(array $argument = [])
 * @method array getSellerTaxonomyVersion(array $argument = [])
 * @method array findSuggestedStyles(array $argument = [])
 * @method array findAllTeams(array $argument = [])
 * @method array findAllUsersForTeam(array $argument = [])
 * @method array findTeams(array $argument = [])
 * @method array getShop_Transaction(array $argument = [])
 * @method array findAllTreasuries(array $argument = [])
 * @method array getTreasury(array $argument = [])
 * @method array deleteTreasury(array $argument = [])
 * @method array findTreasuryComments(array $argument = [])
 * @method array postTreasuryComment(array $argument = [])
 * @method array deleteTreasuryComment(array $argument = [])
 * @method array addTreasuryListing(array $argument = [])
 * @method array removeTreasuryListing(array $argument = [])
 * @method array describeOccasionEnum(array $argument = [])
 * @method array describeRecipientEnum(array $argument = [])
 * @method array describeWhenMadeEnum(array $argument = [])
 * @method array describeWhoMadeEnum(array $argument = [])
 * @method array findAllUsers(array $argument = [])
 * @method array getUser(array $argument = [])
 * @method array findAllUserAddresses(array $argument = [])
 * @method array createUserAddress(array $argument = [])
 * @method array getUserAddress(array $argument = [])
 * @method array deleteUserAddress(array $argument = [])
 * @method array getAvatarImgSrc(array $argument = [])
 * @method array getUserBillingOverview(array $argument = [])
 * @method array getAllUserCarts(array $argument = [])
 * @method array addToCart(array $argument = [])
 * @method array updateCartListingQuantity(array $argument = [])
 * @method array removeCartListing(array $argument = [])
 * @method array getUserCart(array $argument = [])
 * @method array updateCart(array $argument = [])
 * @method array deleteCart(array $argument = [])
 * @method array addAndSelectShippingForApplePay(array $argument = [])
 * @method array findAllCartListings(array $argument = [])
 * @method array saveListingForLater(array $argument = [])
 * @method array getUserCartForShop(array $argument = [])
 * @method array createSingleListingCart(array $argument = [])
 * @method array findAllUserCharges(array $argument = [])
 * @method array getUserChargesMetadata(array $argument = [])
 * @method array getCirclesContainingUser(array $argument = [])
 * @method array getConnectedUser(array $argument = [])
 * @method array unconnectUsers(array $argument = [])
 * @method array listFollowingPages(array $argument = [])
 * @method array followPage(array $argument = [])
 * @method array unfollowPage(array $argument = [])
 * @method array getConnectedUsers(array $argument = [])
 * @method array connectUsers(array $argument = [])
 * @method array findAllUserFavoredBy(array $argument = [])
 * @method array findAllUserFavoriteListings(array $argument = [])
 * @method array findUserFavoriteListings(array $argument = [])
 * @method array createUserFavoriteListings(array $argument = [])
 * @method array deleteUserFavoriteListings(array $argument = [])
 * @method array findAllUserFavoriteUsers(array $argument = [])
 * @method array findUserFavoriteUsers(array $argument = [])
 * @method array createUserFavoriteUsers(array $argument = [])
 * @method array deleteUserFavoriteUsers(array $argument = [])
 * @method array findAllUserFeedbackAsAuthor(array $argument = [])
 * @method array findAllUserFeedbackAsBuyer(array $argument = [])
 * @method array findAllUserFeedbackAsSeller(array $argument = [])
 * @method array findAllUserFeedbackAsSubject(array $argument = [])
 * @method array findAllFeedbackFromBuyers(array $argument = [])
 * @method array findAllFeedbackFromSellers(array $argument = [])
 * @method array findAllUserPayments(array $argument = [])
 * @method array findAllUserPaymentTemplates(array $argument = [])
 * @method array findUserProfile(array $argument = [])
 * @method array updateUserProfile(array $argument = [])
 * @method array findAllUserBuyerReceipts(array $argument = [])
 * @method array findAllUserShippingProfiles(array $argument = [])
 * @method array findAllUserShops(array $argument = [])
 * @method array findAllTeamsForUser(array $argument = [])
 * @method array findAllUserBuyerTransactions(array $argument = [])
 * @method array findAllUserTreasuries(array $argument = [])
 */
class EtsyApi
{
    /** @var Etsy $server */
    private $server;
    /** @var array $methods */
    private $methods = [];
    /** @var TokenCredentials $tokenCredentials */
    private $tokenCredentials;
    /** @var \GuzzleHttp\Client $client */
    private $client;

    /**
     * EtsyApi constructor.
     * @param Etsy $server
     * @param TokenCredentials $tokenCredentials
     */
    public function __construct(Etsy $server, TokenCredentials $tokenCredentials = null)
    {
        $this->server = $server;
        $this->client = $this->server->createHttpClient();
        $this->tokenCredentials = $tokenCredentials;

        $methods_file = dirname(realpath(__FILE__)) . '/methods.json';
        $this->methods = json_decode(file_get_contents($methods_file), true);
//        $this->generateMethodsDoc();
    }

    /**
     * @param $arguments
     * @return mixed
     * @throws EtsyResponseException
     * @throws \Exception
     */
    protected function request($arguments)
    {
        $method = $this->methods[$arguments['method']];
        $args = $arguments['args'];
        $params = $this->prepareParameters($args['params']);
        $data = @$this->prepareData($args['data']);

        $uri = preg_replace_callback('@:(.+?)(\/|$)@', function ($matches) use ($args) {
            return $args["params"][$matches[1]] . $matches[2];
        }, $method['uri']);

        if (!empty($args['associations'])) {
            $params['includes'] = $this->prepareAssociations($args['associations']);
        }

        if (!empty($args['fields'])) {
            $params['fields'] = $this->prepareFields($args['fields']);
        }

        if (!empty($params)) {
            $uri .= "?" . http_build_query($params);
        }

        return $this->handleError($this->sendRequest($method['http_method'], $uri, $data));
    }

    /**
     * @param $method
     * @param $path
     * @param array $params
     * @return array
     * @throws \Exception
     */
    protected function sendRequest($method, $path, $params = [])
    {
        $url = $this->getEndpointUrl($path);

        if ($file = $this->prepareFile($params)) {
            $params = [];
        }

        if ($this->tokenCredentials) {
            $headers = $this->server->getHeaders($this->tokenCredentials, $method, $url, $params);
            $options = [
                'headers' => $headers,
            ];
        } else {
            $options = [
                'query' => ['api_key' => $this->server->getClientCredentials()->getIdentifier()],
            ];
        }

        if (in_array($method, ['POST', 'PUT'])) {
            if ($file) {
                $options['multipart'] = $file;
            } else {
                $options['form_params'] = $params;
            }
        }

        try {
            $response = $this->client->request($method, $url, $options);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            $body = $response->getBody();
            $statusCode = $response->getStatusCode();

            throw new EtsyResponseException("Received error [$body] with status code [$statusCode]", $response);
        }

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * @param $response
     * @return mixed
     * @throws EtsyResponseException
     */
    protected function handleError($response)
    {
        $errors = '';
        $results = !empty($response['results']) ? $response['results'] : [];

        foreach ($results as $result) {
            if (!empty($result['error_messages'])) {
                foreach ($result['error_messages'] as $error_message) {
                    $errors .= $error_message . '; ';
                }
            }
        }

        if (!empty($errors)) {
            throw new EtsyResponseException(rtrim($errors, '; '), $response);
        }

        return $response;
    }

    /**
     * @param $uri
     * @return string
     */
    private function getEndpointUrl($uri)
    {
        return Etsy::API_URL . ltrim($uri, '/');
    }

    /**
     * @param $data
     * @return array
     */
    private function prepareData($data)
    {
        $result = array();
        foreach ($data as $key => $value) {
            $type = gettype($value);
            if ($type !== 'boolean') {
                $result[$key] = $value;
                continue;
            }

            $result[$key] = $value ? 1 : 0;
        }

        return $result;
    }

    /**
     * @param $data
     * @return array|bool
     */
    private function prepareFile($data)
    {
        if (!isset($data['image']) && !isset($data['file'])) {
            return false;
        }

        $key = isset($data['image']) ? 'image' : 'file';

        return [[
            'name' => $key,
            'contents' => fopen($data[$key], 'r')
        ]];
    }

    /**
     * @param $params
     * @return array
     */
    private function prepareParameters($params)
    {
        $query_pairs = array();
        $allowed = array("limit", "offset", "page", "sort_on", "sort_order", "include_private", "language");

        if ($params) {
            foreach ($params as $key => $value) {
                if (in_array($key, $allowed)) {
                    $query_pairs[$key] = $value;
                }
            }
        }

        return $query_pairs;
    }

    /**
     * @param $associations
     * @return mixed
     */
    private function prepareAssociations($associations)
    {
        $includes = array();
        foreach ($associations as $key => $value) {
            if (is_array($value)) {
                $includes[] = $this->buildAssociation($key, $value);
            } else {
                $includes[] = $value;
            }
        }

        return implode(',', $includes);
    }

    /**
     * @param $fields
     * @return mixed
     */
    private function prepareFields($fields)
    {
        return implode(',', $fields);
    }

    /**
     * @param $assoc
     * @param $conf
     * @return string
     */
    private function buildAssociation($assoc, $conf)
    {
        $association = $assoc;
        if (isset($conf['select'])) {
            $association .= "(" . implode(',', $conf['select']) . ")";
        }
        if (isset($conf['scope'])) {
            $association .= ':' . $conf['scope'];
        }
        if (isset($conf['limit'])) {
            $association .= ':' . $conf['limit'];
        }
        if (isset($conf['offset'])) {
            $association .= ':' . $conf['offset'];
        }
        if (isset($conf['associations'])) {
            $association .= '/' . $this->prepareAssociations($conf['associations']);
        }

        return $association;
    }

    /**
     *
     */
    private function generateMethodsDoc()
    {
        $doc = '';
        foreach ($this->methods as $name => $info) {
            $doc .= "* @method array $name(array \$argument = [])\n";
        }

        echo($doc);
        exit;
    }

    /**
     * array('params' => array(), 'data' => array())
     * :params for uri params
     * :data for "post fields"
     *
     * @param $method
     * @param $args
     * @return array
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        if (isset($this->methods[$method])) {
            $validArguments = RequestValidator::validateParams(@$args[0], $this->methods[$method]);
            if (isset($validArguments['_invalid'])) {
                throw new EtsyRequestException('Invalid params for method "' . $method . '": ' . implode(', ', $validArguments['_invalid']) . ' - ' . json_encode($this->methods[$method]));
            }

            return call_user_func_array(array($this, 'request'), array(
                array(
                    'method' => $method,
                    'args' => array(
                        'data' => @$validArguments['_valid'],
                        'params' => @$args[0]['params'],
                        'associations' => @$args[0]['associations'],
                        'fields' => @$args[0]['fields']
                    )
                )));
        } else {
            throw new EtsyRequestException('Method "' . $method . '" not exists');
        }
    }
}