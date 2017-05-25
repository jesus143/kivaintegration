<?php


global $post;
$loanid = get_post_meta($post->ID,'loan_id',true);

$loans = 'http://api.kivaws.org/v1/loans/'.$loanid.'.json';
$lenders = 'http://api.kivaws.org/v1/loans/1234668.json';
$args = array(
  'headers' => array( "Content-type" => "application/json" )
);
$response = wp_remote_get( $loans,$args );

$data = json_decode($response['body']);

$dataloans = $data->loans[0];

if(array_key_exists("code",$data))  {

  echo $data->message;

}else{
// echo "<pre>";
// print_r($data->loans[0]);
// echo "</pre>";
$partner = wp_remote_get( 'http://api.kivaws.org/v1/partners/'.$dataloans->partner_id.'.json' );

$partner = json_decode($partner['body']);
$partner = $partner->partners;
$partner = $partner[0];
/* echo "<pre>";
print_r($dataloans);
echo "</pre>"; */


?>

<style>
#page-content{
width: 100% !important;
padding: 0  !important;
}
.pageTitle{
  display:none;
}

#map {
	height: 268px;
	width: 100%;
}

</style>

<div class="e3ve-charity-page-container">
  <div class="charity-top-bar">
    <h3>Fund a loan, get repaid, fund another.<span class="question-icon">?</span></h3>
  </div>
  <div class="charity-how-it-works">
    <div class="chiw-heading">
      <h2 class="chiw-heading-main">How it works</h2>
      <h2 class="chiw-heading-secondary">Choose a borrower</h2>
      <p>Browse categories of borrowers— people looking to grow businesses, go to school, switch to clean energy and more.</p>
    </div>
    <div class="chiw-row">
      <div class="chiw-col-3">
        <h2>Repeat!</h2>
        <p>Use the repayment to support another borrower, or withdraw your money.</p>
      </div>
      <div class="chiw-col-3">
        <div class="chiw-img"> <img src="https://testing.umbrellasupport.co.uk/wp-content/uploads/2017/02/hiw-img.png"> </div>
        <h2>Get repaid</h2>
        <p>Receive updates on your loans and see the dollars return to your Kiva account.</p>
        <p><a href="https://www.kiva.org/about/how" target="_blank">Learn more about how Kiva works</a></p>
      </div>
      <div class="chiw-col-3">
        <h2>Make a loan</h2>
        <p>Select a borrower who you connect with and help fund a loan with as little as $25.</p>
      </div>
    </div>
    <div class="chiw-hide"> X </div>
  </div>
  <div class="chiw-row-1 chiw-container">
    <div class="chiw-col-2-60"> <img  src="http://www.kiva.org/img/s300/<?php echo $dataloans->image->id; ?>.jpg"> </div>
    <div class="chiw-col-2-40">
      <h1 class="chiw-funded">Funded</h1>
      <p class="chiw-total-loan">Total loan: $<?php echo $dataloans->funded_amount; ?></p>
      <p class="chiw-borrower-name"><?php echo $dataloans->name; ?></p>
      <div class="chiw-borrower-address">
        <div class="cba-country-flag"> <img src="https://www-kiva-org-0.global.ssl.fastly.net/images/flags/<?php echo strtolower($dataloans->location->country_code); ?>.svg"> </div>
        <div class="cba-address">
          <p><span class="cba-link"><?php echo $dataloans->location->town.", ".$dataloans->location->country; ?></span> / <?php echo $dataloans->activity; ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="chiw-main-intro">
    <h2>A loan of $<?php echo $dataloans->funded_amount; ?> helped <?php echo $dataloans->use;  ?></h2>
  </div>
  <div class="chiw-main-content-container">
    <div class="cmc-left">
      <div id="e3ve-accordion-container" class="cmcl-row">
        <div class="e3ve-accordianheader">
          <h2><?php echo $dataloans->name; ?>'s story<i class="fa fa-angle-down"></i></h2>
        </div>
        <div class="e3ve-accordianbody cmc-left-story">
        <?php $description = $dataloans->description; ?>


          <?php echo $description->texts->{$description->languages[0]} ?>
        </div>
        <hr>
        <div class="e3ve-accordianheader">
          <h2>This loan is special because:<i class="fa fa-angle-down"></i></h2>
        </div>
        <div class="e3ve-accordianbody cmc-special-loan">
          <h1 class="cmc-left-endorsement">It provides training and<br>
            capital for this borrower.</h1>
        </div>
        <hr>
        <div class="e3ve-accordianheader">
          <h2>More about this loan<i class="fa fa-angle-down"></i></h2>
        </div>
	<!--<div class="e3ve-accordianbody cmc-left-about">
	  <p><strong>About <?php echo $partner->name; ?>:</strong></p>
	  <p>Community Economic Ventures, Inc. (CEVI), based in Bohol, was awarded the Platinum Award for Transparency in Social Performance Reporting by CGAP. Social performance monitoring is imperative in measuring a microfinance institution’s effectiveness. The fact that CEVI is participating in this process speaks volumes about the organization’s commitment to serving its clients effectively. In addition to providing credit for its clients, CEVI provides savings, insurance, and training through regular cluster group meetings.</p>
	  <p>You can show your support for CEVI by joining the <a href="https://www.kiva.org/team/friends_of_cevi_philippines">Friends of CEVI Kiva Lending Team</a>. Learn more by visiting the <a href="https://cevi.org.ph">CEVI website</a>.</p>
	</div>-->
        <hr>
        <div class="e3ve-accordianheader">
          <h2>Country information<i class="fa fa-angle-down"></i></h2>
		  		<?php

				$latlang = explode(" ", $dataloans->location->geo->pairs);



				?>
        </div>
        <div class="e3ve-accordianbody cmc-country">

          <div class="cmc-map">  <div id="map"></div> </div>


		<script>
		  function initMap() {
			var uluru = {lat: <?php echo $latlang[0]; ?>, lng: <?php echo $latlang[1]; ?>};
			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 4,
			  center: uluru
			});
			var marker = new google.maps.Marker({
			  position: uluru,
			  map: map
			});
		  }
		</script>
		<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmiWP1WwLuZpJosHCQ53S1HQOj82gqXK8&callback=initMap">
		</script>


          <!--<ul class="loan-info">
            <li>
              <div>Average annual income (USD):</div>
              <div class="loan-info-result">$7,000</div>
            </li>
            <li>
              <div>Funds lent in Philippines:</div>
              <div class="loan-info-result">$82,098,050</div>
            </li>
            <li>
              <div>Philippines Pesos (PHP) = $1:</div>
              <div class="loan-info-result">50.0</div>
            </li>
            <li>
              <div>Loans currently fundraising:</div>
              <div class="loan-info-result">81</div>
            </li>
          </ul>-->
        </div>
        <hr>
        <div class="e3ve-accordianheader">
          <h2>Tags<i class="fa fa-angle-down"></i></h2>
        </div>
        <div class="e3ve-accordianbody cmc-tags">
          <div class="cmc-left-tags">
          <?php $tags = $dataloans->tags; ?>
          <?php

          foreach($tags as $tag){

          ?>
          <a href="#"><?php echo $tag->name; ?></a><span> |

          <?php } ?>
          </div>
          <p>Loan tags help lenders find loans that match certain areas of interest.</p>
        </div>
      </div>
    </div>
    <div class="cmc-right">
      <div class="cmcr-row">
        <h2>Loan details</h2>


        <?php //echo $img = wp_remote_get(  ); ?>
        <p><img src="https://testing.umbrellasupport.co.uk/wp-content/uploads/2017/02/loan-details-icon.png" width="70" height="70"></p>
        <h2 class="cmcr-loanlength">Loan length:</h2>
        <h1><?php echo $dataloans->terms->repayment_term; ?> months</h1>
        <div class="cmcr-links">
          <p class="cmcr-repayment"><span>Repayment schedule</span>: <?php echo $dataloans->terms->repayment_term; ?></p>
          <p class="cmcr-disbursed"><span>Disbursed date</span>: <?php echo date("M d, Y", strtotime($dataloans->terms->disbursal_date)); ?></p>
          <p class="cmcr-loss"><span>Currency exchange loss</span>: <?php echo $dataloans->terms->loss_liability->currency_exchange; ?></p>
          <p class="cmcr-partner"><span>Facilitated by Field Partner</span>: <?php echo $partner->name; ?></p>
          <p class="cmcr-interest"><span>Is borrower paying interest</span>? Yes</p>
          <p class="cmcr-rating"><span>Field Partner risk rating</span>:

          <?php $partner_rating = intval($partner->rating); ?>
          <?php for($i=1;$i<=$partner_rating;$i++){ ?>
          <span class="rating-star"><img src="https://testing.umbrellasupport.co.uk/wp-content/uploads/2017/02/risk-rating.png"></span>
          <?php } ?>
        </p>
        </div>
      </div>
      <div class="cmc-right-popup">
        <div class="cmcll-popup-loanlength">
          <div class="cmcll-popup-close">
            <p>X</p>
          </div>
          <div class="cmcll-popup-wrapper">
            <div class="cmcll-popup-content">
              <h1>Loan length/repayment term</h1>
              <p>The loan length or repayment term is the number of months it takes from the point that the loan is disbursed to the borrower to the point when the last repayment is due to be paid to Kiva lenders.</p>
            </div>
          </div>
        </div>
        <div class="cmcll-popup-repayment">
          <div class="cmcll-popup-close">
            <p>X</p>
          </div>
          <div class="cmcll-popup-wrapper">
            <div class="cmcll-popup-content">
              <h1>Repayment schedule</h1>
              <p>The loan's repayment schedule describes the frequency with which repayments on the loan. It can be any of the following:</p>

              <p>Monthly - One repayment made per month<br>At end of term - One repayment made at the end of the loan term<br>Irregularly - Any other repayment schedule</p>

              <p>To see a detailed repayment schedule for a loan, please click the "Repayment Schedule" link on the loan profile.</p>
            </div>
          </div>
        </div>
        <div class="cmcll-popup-disbursed">
          <div class="cmcll-popup-close">
            <p>X</p>
          </div>
          <div class="cmcll-popup-wrapper">
            <div class="cmcll-popup-content">
              <h1>What is the disbursed date?</h1>
              <p>The disbursed date indicates the date that the borrower receives their loan funds. Loan disbursal for loans on Kiva can happen anywhere from 30 days before to 90 days after the loan is posted on the Kiva website. Direct loans are always post-disbursed, and will be done only after the loan has fully fundraised on Kiva.</p>

              <p>In the case of partner loans, many of Kiva's Field Partners choose to disburse loan funds before the loan request is posted on Kiva. We allow pre-disbursal because it ensures that the funds reach the borrower as soon as they are needed. Loan funds from Kiva lenders then go to backfill that amount and as a lender you assume the risk of the loan. By doing this, our Field Partners assume the risk that, if the loan isn't funded by Kiva lenders, the Field Partner has to fund the loan without any funds from Kiva lenders.</p>

              <p>If a partner loan is not pre-disbursed, it will be listed on Kiva with an expected "post-disbursed" date. If a post-disbursed loan is not funded on Kiva, there is a chance that the borrower may not receive their loan. Some Field Partners choose to disburse loans with other sources of funding, while other partners don't have the resources available to fund loans without Kiva lenders' support. No direct loans will be disbursed unless they fully fundraise on Kiva.</p>
            </div>
          </div>
        </div>
        <div class="cmcll-popup-loss">
          <div class="cmcll-popup-close">
            <p>X</p>
          </div>
          <div class="cmcll-popup-wrapper">
            <div class="cmcll-popup-content">
              <h1>What is currency exchange loss and how could it affect my Kiva loans?</h1>
              <p>When lending funds across national boundaries, the local currency in the Field Partner's country of operation may lose some of its value relative to the USD, thus requiring the Field Partner to use more of its local currency to reimburse Kiva in USD. Kiva offers Field Partners the option to protect themselves against severe currency fluctuations (a US dollar appreciation of over 10% relative to the local currency) by sharing any losses greater than 10% with Kiva lenders. By bearing these losses, lenders are able to protect the Field Partner and its borrowers from catastrophic currency devaluations.</p>

              <p>The Field Partner-specified currency exchange loss to lenders can be one of three values: Covered, Possible, or N/A.</p>

              <p>Covered: The Field Partner has opted to cover any losses on the loan that are due to currency fluctuation. Lenders will not bear losses due to currency fluctuation.</p>

              <p>Possible: The Field Partner has opted not to cover losses on the loan that are due to currency fluctuation. In this situation, lenders face additional risk because they will bear losses greater than 10%.</p>

              <p>N/A: The Field Partner disburses loans to borrowers in USD so their loans are not subject to any foreign currency conversion.</p>
            </div>
          </div>
        </div>
        <div class="cmcll-popup-partner">
          <div class="cmcll-popup-close">
            <p>X</p>
          </div>
          <div class="cmcll-popup-wrapper">
            <div class="cmcll-popup-content">
              <h1>How are loans facilitated?</h1>
              <p>Kiva loans are facilitated through 2 models, partner and direct, that enable us to reach the greatest number of people around the world.</p>

              <p>For partner loans, borrowers apply to a local Field Partner, which manages the loan on the ground. Field Partners are responsible for screening borrowers, disbursing loans, posting borrowers to the Kiva website for funding, collecting repayments and otherwise administering Kiva loans on the ground to borrowers.</p>

              <p>For direct loans, borrowers apply through the Kiva website and may or may not be endorsed by a Trustee. Unlike Field Partners, Trustees don't handle any financial transactions or have any duty to repay loans on behalf of their borrowers. Instead, Trustees take the role of providing support and business advice to their borrowers throughout the term of the loan.</p>
            </div>
          </div>
        </div>
        <div class="cmcll-popup-interest">
          <div class="cmcll-popup-close">
            <p>X</p>
          </div>
          <div class="cmcll-popup-wrapper">
            <div class="cmcll-popup-content">
              <h1>Do Kiva borrowers pay any interest on their loans?</h1>
              <p>Yes, most borrowers on Kiva do pay interest to Kiva’s local Field Partners in some form. Kiva and Kiva lenders do not receive interest on Kiva loans.</p>

              <p>Field Partners collect interest from borrowers because there are many expenses associated with providing small loans in developing markets, especially in rural areas. Many of Kiva’s Field Partners also provide additional services with loans, including training, financial literacy classes or health services.</p>

              <p>Kiva will not partner with an organization that charges unreasonable interest rates, and we require Field Partners to fully disclose their rates. Kiva only partners with organizations and microfinance institutions that have a social mission to serve the poor, unbanked and underserved.</p>

              <p>There are some 0% interest loans on Kiva, including all direct loans, which are loans that are not made through a Field Partner. To learn more about the interest rates Kiva borrowers pay, look at the "Average cost to borrower" field.</p>
            </div>
          </div>
        </div>
        <div class="cmcll-popup-rating">
          <div class="cmcll-popup-close">
            <p>X</p>
          </div>
          <div class="cmcll-popup-wrapper">
            <div class="cmcll-popup-content">
              <h1>What is a risk rating?</h1>
              <p>There are many levels of risk associated with Kiva loans, which are explained on our website here: <a href="https://www.kiva.org/about/risk" target="_blank">kiva.org/about/risk</a></p>

              <p>The Field Partner risk rating reflects the risk of institutional default associated with each of Kiva’s Field Partners. A 0.5-star rating means the organization has a relatively higher risk of institutional default, while a 5-star rating indicates the organization is at a relatively lower risk of default, based on Kiva's analysis and the available information. Note that Field Partners with Kiva’s lowest <a href="https://www.kiva.org/about/risk/kiva-role" target="_blank">credit tier</a> undergo a lighter level of due diligence and hence do not receive a risk rating; instead, in places where a risk rating would normally appear on Kiva’s website, these partners are labeled as “Experimental.” For more information, see "<a href="https://www.kiva.org/help?solution=solution-50150000000SbqKAAS" target="_blank">What is an Experimental Field Partner?</a>"</p>

              <p>Direct loans also do not receive a formal risk rating. Instead, these loans are approved through “social underwriting”, where trustworthiness is determined by friends &amp; family lending a portion of the loan request, or by a Kiva approved Trustee vouching for the borrower. Direct loans will appear as "Unrated" and lenders should always assume these loans represent the highest level of repayment risk on Kiva.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php } ?>