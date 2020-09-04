<?php
namespace Tests\Unit;

use RestiveSDK\ApiQueryBuilder;

class ApiQueryBuilderTest extends \Orchestra\Testbench\TestCase
{

    /** @test */
    public function instantiates_the_api_query_builder()
    {
        $aqb = new ApiQueryBuilder();
        $fragments = $aqb->getFragments();
        $this->assertCount(0, $fragments);
    }

    /** @test */
    public function adds_an_empty_select_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->select();
        $fragments = $aqb->getFragments();
        $this->assertEquals('columns', $fragments[0]['type']);
    }

    /** @test */
    public function adds_a_select_method_with_parameters_as_array()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->select(['id', 'name']);
        $fragments = $aqb->getFragments();
        $this->assertEquals('columns', $fragments[0]['type']);
        $this->assertEquals('id,name', $fragments[0]['parameters']);
    }

    /** @test */
    public function adds_a_select_method_with_parameters_as_arguments()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->select('id', 'name');
        $fragments = $aqb->getFragments();
        $this->assertEquals('columns', $fragments[0]['type']);
        $this->assertEquals('id,name', $fragments[0]['parameters']);
    }

    /** @test */
    public function adds_a_with_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->with('posts', 'tags');
        $fragments = $aqb->getFragments();
        $this->assertEquals('with', $fragments[0]['type']);
        $this->assertEquals('posts,tags', $fragments[0]['parameters']);
    }

    /** @test */
    public function adds_a_simple_where_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->where('id', '=', 1);
        $fragments = $aqb->getFragments();
        $this->assertEquals('where', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('=', $fragments[0]['parameters'][1]);
        $this->assertEquals(1, $fragments[0]['parameters'][2]);
    }

    /** @test */
    public function adds_a_simple_where_method_with_default_operator()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->where('id', 1);
        $fragments = $aqb->getFragments();
        $this->assertEquals('where', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('=', $fragments[0]['parameters'][1]);
        $this->assertEquals(1, $fragments[0]['parameters'][2]);
    }

    /** @test */
    public function adds_a_simple_where_method_with_invalid_operator_value()
    {
        $aqb = new ApiQueryBuilder();
        $this->expectException('InvalidArgumentException');
        $aqb->where('id', 'like', null);
    }

    /** @test */
    public function adds_a_simple_where_method_with_invalid_operator()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->where('id', 'z',  1);
        $fragments = $aqb->getFragments();
        $this->assertEquals('where', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('=', $fragments[0]['parameters'][1]);
        $this->assertEquals(1, $fragments[0]['parameters'][2]);
    }


    /** @test */
    public function adds_a_simple_or_where_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->orWhere('id', '=', 1);
        $fragments = $aqb->getFragments();
        $this->assertEquals('orWhere', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('=', $fragments[0]['parameters'][1]);
        $this->assertEquals(1, $fragments[0]['parameters'][2]);
    }

    /** @test */
    public function adds_a_simple_wherein_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->whereIn('id', [1,2,3]);
        $fragments = $aqb->getFragments();
        $this->assertEquals('whereIn', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('1,2,3', $fragments[0]['parameters'][1]);
    }


    /** @test */
    public function adds_a_simple_wherenotin_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->whereNotIn('id', [1,2,3]);
        $fragments = $aqb->getFragments();
        $this->assertEquals('whereNotIn', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('1,2,3', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_simple_orwherein_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->orWhereIn('id', [1,2,3]);
        $fragments = $aqb->getFragments();
        $this->assertEquals('orWhereIn', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('1,2,3', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_simple_orwherenotin_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->orWhereNotIn('id', [1,2,3]);
        $fragments = $aqb->getFragments();
        $this->assertEquals('orWhereNotIn', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('1,2,3', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_simple_wherebetween_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->whereBetween('id', [1,2]);
        $fragments = $aqb->getFragments();
        $this->assertEquals('whereBetween', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('1,2', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_simple_wherenotbetween_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->whereNotBetween('id', [1,2]);
        $fragments = $aqb->getFragments();
        $this->assertEquals('whereNotBetween', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('1,2', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_simple_orwherebetween_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->orWhereBetween('id', [1,2]);
        $fragments = $aqb->getFragments();
        $this->assertEquals('orWhereBetween', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('1,2', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_simple_orwherenotbetween_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->orWhereNotBetween('id', [1,2]);
        $fragments = $aqb->getFragments();
        $this->assertEquals('orWhereNotBetween', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('1,2', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_innerjoin_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->join('user', 'id', '=', 'contact_id');
        $fragments = $aqb->getFragments();
        $this->assertEquals('join', $fragments[0]['type']);
        $this->assertEquals('user', $fragments[0]['parameters'][0]);
        $this->assertEquals('', $fragments[0]['parameters'][1]);
        $this->assertEquals('id', $fragments[0]['parameters'][2]);
        $this->assertEquals('contact_id', $fragments[0]['parameters'][3]);
        $this->assertEquals('=', $fragments[0]['parameters'][4]);
    }

    /** @test */
    public function adds_a_rightjoin_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->rightJoin('user', 'id', '=', 'contact_id');
        $fragments = $aqb->getFragments();
        $this->assertEquals('right', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_leftjoin_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->leftJoin('user', 'id', '=', 'contact_id');
        $fragments = $aqb->getFragments();
        $this->assertEquals('left', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_crossjoin_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->crossJoin('user');
        $fragments = $aqb->getFragments();
        $this->assertEquals('cross', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function adds_a_withtrashed_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->withTrashed();
        $fragments = $aqb->getFragments();
        $this->assertEquals('withTrashed', $fragments[0]['type']);
    }

    /** @test */
    public function adds_a_onlytrashed_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->onlyTrashed();
        $fragments = $aqb->getFragments();
        $this->assertEquals('onlyTrashed', $fragments[0]['type']);
    }

    /** @test */
    public function adds_a_scope_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->scope();
        $fragments = $aqb->getFragments();
        $this->assertEquals('scope', $fragments[0]['type']);
        $this->assertEquals('scope', $fragments[0]['parameters'][0]);
    }

    /** @test */
    public function adds_a_orderby_method()
    {
        $aqb = new ApiQueryBuilder();
        $aqb = $aqb->orderBy('id', 'desc');
        $fragments = $aqb->getFragments();
        $this->assertEquals('orderBy', $fragments[0]['type']);
        $this->assertEquals('id', $fragments[0]['parameters'][0]);
        $this->assertEquals('desc', $fragments[0]['parameters'][1]);
    }

    /** @test */
    public function builds_a_url()
    {
        $aqb = new ApiQueryBuilder();
        $url = $aqb->where('id', 1)
            ->orWhere('id', 2)
            ->whereIn('id', [2,3,4])
            ->whereBetween('id', [3,4])
            ->orderBy('id', 'desc')
            ->crossJoin('user')
            ->select('id', 'name')->select('foo')
            ->with('variants1', 'variants2')
            ->with('variants3')
            ->get();
        $this->assertEquals("columns[]=id,name,foo&join[]=cross:user::&with[]=variants1,variants2,variants3&where[]=id:eq:1&orWhere[]=id:eq:2&whereIn[]=id:(2,3,4)&whereBetween[]=id:3:4&orderBy[]=-id&", $url);

        $aqb = new ApiQueryBuilder();
        $url = $aqb->where('id', 1)
            ->orWhere('id', 2)
            ->orderBy('id')->orderBy('name', 'desc')
            ->limit(1)
            ->get();
        $this->assertEquals("where[]=id:eq:1&orWhere[]=id:eq:2&orderBy[]=id,-name&limit[]=1&", $url);

        $aqb = new ApiQueryBuilder();
        $url = $aqb->where('id', 1)
            ->with('variants')
            ->limit(1)
            ->get();
        $this->assertEquals("with[]=variants&where[]=id:eq:1&limit[]=1&", $url);

    }

}