<?php
class _ctm
	{
    public $id=0;
    public $id_customer=0;
    public $dt_creation;
    public $dt_expiration;
    public $base;
    public $solde;
#####################################################################################################################################################
    public function chk_all_ctm($sugar,$js,$id_customer)
        {
        $chk_ctm=db_single_read("select count(*) as cnt from customer_ctm where id_customer = $id_customer and status = '1';");//on verifie si on a  un contrat ouvert
        if($chk_ctm->cnt>0)
            {
            $ctm_tmp=db_read("select * from customer_ctm where id_customer = $id_customer and status = 1;");//on tourne sur tout les contrat valable
            while($ctm = $ctm_tmp->fetch())
                {
                $base=$ctm->montant_base;
                $item_repair_tmp=db_read("select * from repair_item where id_ctr = $ctm->id");
                while($item_repair = $item_repair_tmp->fetch())
                    {
                    $base-=$item_repair->prix;
                    }
                if($base<=0)
                    {
                    db_write("update customer_ctm set status=0 where id = $ctm->id");//si il ne reste plus de min dans le contrat on le desactive et on reload la page
                    //$js->alert("Le contrat no $ctm->id n est plus valable il sera desactiver");
                    return 0;
                    }
                else 
                    {
                    //$js->alert("Le contrat no $ctm->id est valable il sera utiliser");
                    return $ctm->id;
                    }
                }
            }
        else return 0;
        }
#####################################################################################################################################################
    public function load($id_ctm)
        {
        $ctm_tmp=db_single_read("select * from customer_ctm where id=$id_ctm");
        $this->id=$ctm_tmp->id;
        $this->id_customer=$ctm_tmp->id_customer;
        $this->dt_creation=$ctm_tmp->dt_in;
        $this->dt_expiration=$ctm_tmp->dt_out;
        $this->base=$ctm_tmp->montant_base;
        $retrait=0;
        $deja_payer_tmp=db_read("select * from repair_item where id_ctr = $this->id");
        while($deja_payer = $deja_payer_tmp->fetch())
            {
            $retrait+=$deja_payer->prix;
            }
        $this->solde=(($this->base)-$retrait);
        }
#####################################################################################################################################################
	}
?>