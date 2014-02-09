<?php
namespace IComeFromTheNet\Ledger\DB;

use DateTime;
use Aura\Marshal\Entity\GenericEntity;
use Doctrine\Common\Collections\Collection;
use IComeFromTheNet\Ledger\DB\TemporalGatewayInterface;

/**
 * Interface for decorate that provided wrapper for
 * a standard database tablegateway with methods to manage
 * temporal versioning.
 * 
 * 
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 * @since 1.0.0
 * 
 */
interface TemporalGatewayDeceratorInterface 
{
    
    
    /**
     *  Check if the given slot is available for
     *  the entity
     * 
     *  @access public
     *  @return boolean true if slot is available
     *  @param string $entitySlug the slug of the entity
     *  @param DateTime $from the slot opening date
     *  @param DateTime $to the slot closing date
     * 
     */ 
    public function isSlotAvailable($entitySlug,DateTime $from, DateTime $to);

    
    /**
     * Find the current slot for an entirt
     * 
     * @return Aura\Marshal\Entity\GenericEntity the entity the wrapped gateway represents
     * @access public
     * @param string $entitySlug the slug of the entity
     * @param DateTime $processingDate the ledger processing date.
     */ 
    public function findCurrentSlot($entitySlug,DateTime $processingDate);
    
    /**
     * Close a slot by setting the to(max date) to the given value
     * or if that not provided  use the processingDate.
     * 
     * @access public
     * @param string $entitySlug the slug name of the entity
     * @param DateTime $processingDate the procesing date of the ledger
     * @param DateTime $from the opening date of the slot to match
     * @param DateTime $to optional closing date of the slot will use processing date if not provided
     * @return boolean true if slot closed.
     */ 
    public function closeSlot($entitySlug,DateTime $processingDate, 
                              DateTime $from, DateTime $to = null );
    
    /**
     * Finds a slot for an entity.  
     * 
     * @return Aura\Marshal\Entity\GenericEntity the entity the wrapped gateway represents
     * @access public
     * @param string $entitySlug the slug of the entity
     * @param DateTime $from the slot opening date.
     */
    public function findOneSlot($entitySlug,DateTime $from);
    
    
    /**
     * Finds all slots occur after a date for an entity
     * 
     * @access public
     * @return Doctrine\Common\Collections\Collection a collection of entities
     * @param string $entitySlug the slug of the entity
     * @param DateTime $from the opening date of the first slot
     * @param DateTime $until the date that last slot ends
     */ 
    public function findManySlotsUntil($entitySlug,DateTime $from, DateTime $until);
    
    
    /**
     * Find all current slots for a given processing date
     * 
     * @access public
     * @return Doctrine\Common\Collections\Collection a collection of entities
     * @param DateTime $processingDate the ledger processing datetime
     */ 
    public function findAllCurrentSlots(DateTime $processingDate);
    
    
    /**
     * Fetch the assigned table gateway
     * 
     * @access public
     * @return IComeFromTheNet\Ledger\Entity\TemporalGatewayInterface
     * 
     */ 
    public function getTableGateway();    
}
/* End of File */


