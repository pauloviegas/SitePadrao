<?php

class Home extends AdminController
{
    
    
    
    public function __construct()
    {
        
        parent::__construct();
    }
    
    
    
    public function index()
    {
        //Avisos
        $this->data['sucesso'] = ($this->session->flashdata('sucesso')) ? $this->session->flashdata('sucesso') : FALSE;
        $this->data['noticia'] = ($this->session->flashdata('noticia')) ? $this->session->flashdata('noticia') : FALSE;
        $this->data['validacao'] = (validation_errors()) ? validation_errors() : FALSE;
        $this->data['erro'] = ($this->session->flashdata('erro')) ? $this->session->flashdata('erro') : FALSE;
        
        //Redirecionamento
        $this->load->view('home/home', $this->data);
    }
}