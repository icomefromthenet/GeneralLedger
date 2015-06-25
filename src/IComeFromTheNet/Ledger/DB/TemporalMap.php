<?php
namespace IComeFromTheNet\Ledger\DB;

use Doctrine\DBAL\Schema\Column;

/**
 *  Entity Maps Temporal Columns and Temporal Fields
 * 
 *  @author Lewis Dyer <getintouch@icomefromthenet.com>
 *  @since 1.0.0
 * 
 */ 
class TemporalMap
{
    
    protected $slugColumn;
    protected $fromColumn;
    protected $toColumn;
    protected $postingDateColumn;
    
    /**
     * Class constructor
     * 
     * @access public
     * @return void
     * @param Column $slugColumn the slug (identity) name column
     * @param Column $fromColumn the opening date column
     * @param Column $toColumn to max date column
     * @param Column $postingDateColumn the posting date of the entry
     * 
     */ 
    public function __construct (Column $slugColumn, Column $fromColumn, Column $toColumn, Column $postingDateColumn)
    {
       $this->slugColumn        = $slugColumn;
       $this->fromColumn        = $fromColumn;
       $this->toColumn          = $toColumn;
       $this->postingDateColumn = $postingDateColumn; 
    }

    /**
     * Fetch the identity slug column
     * 
     * @access public
     * @return Doctrine\DBAL\Schema\Column;
     * 
     */ 
    public function getSlugColumn()
    {
        return $this->slugColumn;
    }
    
    /**
     * Fetch opening date column
     * 
     * @access public
     * @return Doctrine\DBAL\Schema\Column the opening date column
     * 
     */ 
    public function getFromColumn()
    {
        return $this->fromColumn;
    }
    
    /**
     * Fetch the closing date column 
     * 
     * @access public
     * @return Doctrine\DBAL\Schema\Column the max date column
     */ 
    public function getToColumn()
    {
        return $this->toColumn;
    }
    
    
    /**
     * Fetch the posting date column 
     * 
     * @access public
     * @return Doctrine\DBAL\Schema\Column the posting date date column
     */ 
    public function getPostingDateColumn()
    {
        return $this->postingDateColumn;
    }
    
}
/* End of file */