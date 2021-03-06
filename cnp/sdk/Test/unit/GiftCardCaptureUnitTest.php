<?php

/*
 * Copyright (c) 2011 Vantiv eCommerce Inc.
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */
namespace cnp\sdk\Test\unit;

use cnp\sdk\CnpOnlineRequest;

class GiftCardCaptureUnitTest extends \PHPUnit_Framework_TestCase {
	public function test_simple_GiftCardCapture() {
		$hash_in = array (
				'cnpTxnId' => '1234567890',
				'id' => 'id',
				'reportGroup'=>'Planets',
				'captureAmount' => '123',
				'card' => array (
						'type' => 'GC',
						'number' => '4100000000000001',
						'expDate' => '0118',
						'cardValidationNum' => '411',
						'pin' => '1234'
						 
				)
				,
				'originalRefCode' => '101',
				'originalAmount' => '34561' 
		);
		$mock = $this->getMock ('cnp\sdk\CnpXmlMapper');
		$mock->expects ( $this->once () )->method ( 'request' )->with ( $this->matchesRegularExpression ( '/.*<cnpTxnId>1234567890.*<captureAmount>123.*<card><type>GC.*<number>4100000000000001.*<expDate>0118.*<cardValidationNum>411.*<pin>1234.*<originalRefCode>101.*<originalAmount>34561.*/' ) );
		
		$cnpTest = new CnpOnlineRequest ();
		$cnpTest->newXML = $mock;
		$cnpTest->giftCardCaptureRequest ( $hash_in );
	}
	public function test_no_txnid() {
		$hash_in = array (
				'reportGroup' => 'Planets',
				'captureAmount' => '106',
				'id' => 'id' 
		);
		$cnpTest = new CnpOnlineRequest ();
		$this->setExpectedException ( 'InvalidArgumentException', 'Missing Required Field: /cnpTxnId/' );
		$cnpTest->captureRequest ( $hash_in );
	}
}
