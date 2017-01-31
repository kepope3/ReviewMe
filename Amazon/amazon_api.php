<?php

class amazon_api {



    public function getReviewURL($ASIN)
    {
        $uri = "/onca/xml";

        $params = array(
            "Service" => "AWSECommerceService",
            "Operation" => "ItemLookup",
            "AWSAccessKeyId" => $this->aws_access_key_id,
            "AssociateTag" => "cam05a-20",
            "ItemId" => $ASIN,
            "IdType" => "ASIN"
        );

// Set current timestamp if not set
        if (!isset($params["Timestamp"]))
        {
            $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
        }

// Sort the parameters by key
        ksort($params);

        $pairs = array();

        foreach ($params as $key => $value)
        {
            array_push($pairs, rawurlencode($key) . "=" . rawurlencode($value));
        }

// Generate the canonical query
        $canonical_query_string = join("&", $pairs);

// Generate the string to be signed
        $string_to_sign = "GET\n" . $this->endpoint . "\n" . $uri . "\n" . $canonical_query_string;

// Generate the signature required by the Product Advertising API
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this->aws_secret_key, true));

// Generate the signed URL
        $request_url = 'http://' . $this->endpoint . $uri . '?' . $canonical_query_string . '&Signature=' . rawurlencode($signature);

//echo "Signed URL: \"".$request_url."\"";

        $dom = new DOMDocument('1.0');

        @$dom->load($request_url);

        $anchors = $dom->getElementsByTagName('ItemLink');
        $productReviewURL = null;
        foreach ($anchors as $itemLink)
        {
            $description = $itemLink->getElementsByTagName('Description');
            if ($description->item(0)->nodeValue == 'All Customer Reviews')
            {
                $productReviewURL = $itemLink->getElementsByTagName('URL')->item(0)->nodeValue;
                break;
            }
        }
        return $productReviewURL;
    }

}

?>