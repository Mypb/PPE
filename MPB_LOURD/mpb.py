#!/usr/bin/pythomn
# -*- coding: iso-8859-1 -*-

try:
    import wx
    import wx.calendar
except ImportError:
    raise ImportError,"Le module wxPython est nécessaire au fonctionnement du programme"
import sqlite3
import time

MyPersonalBank = wx.App()

bdd = sqlite3.connect("mpb.db")
c = bdd.cursor()

fPrincipal = wx.Frame(None,-1,"MyPersonalBank")
fPrincipal.Show()

fCreerCompte = wx.Frame(fPrincipal,-1,"Créer un compte")
pCreercompte = wx.Panel(fCreerCompte,-1)

fCreerOperation = wx.Frame(fPrincipal,-1,"Créer une opération")
pCreerOperation = wx.Panel(fCreerOperation,-1)

pOperation = wx.Panel(fPrincipal,-1)

bId,cId = 0,0

def fenetreCreerBanque(bId,cId):
    
    def onBoutonCreerBanque(event):
        if champIntitule.GetValue() or None or champcBanque.GetValue() or None or champcGuichet.GetValue() or None:
            c.execute("INSERT INTO banques (bnq_intitule,bnq_cBanque,bnq_cGuichet) VALUES (?,?,?)",(champIntitule.GetValue(),champcBanque.GetValue(),champcGuichet.GetValue(),))
            bdd.commit()
            fCreerBanque.Close()
            programme(bId,cId,pOperation)
    
    fCreerBanque = wx.Frame(fPrincipal,-1,"Créer une banque")
    pCreerBanque = wx.Panel(fCreerBanque,-1)
    
    sizer = wx.GridBagSizer(16,16)
    sizer2 = wx.BoxSizer(wx.VERTICAL)
    
    labelIntitule = wx.StaticText(pCreerBanque,-1,"Intitulé :")
    champIntitule = wx.TextCtrl(pCreerBanque,-1)
    sizer.Add(labelIntitule,(0,0),(1,1))
    sizer.Add(champIntitule,(0,1),(1,1))
    
    labelcBanque = wx.StaticText(pCreerBanque,-1,"Code banque :")
    champcBanque = wx.TextCtrl(pCreerBanque,-1)
    sizer.Add(labelcBanque,(1,0),(1,1))
    sizer.Add(champcBanque,(1,1),(1,1))
    
    labelcGuichet = wx.StaticText(pCreerBanque,-1,"Code guichet :")
    champcGuichet = wx.TextCtrl(pCreerBanque,-1)
    sizer.Add(labelcGuichet,(2,0),(1,1))
    sizer.Add(champcGuichet,(2,1),(1,1))
    
    boutonCreer = wx.Button(pCreerBanque,-1,"Créer une banque")
    fCreerBanque.Bind(wx.EVT_BUTTON,onBoutonCreerBanque,boutonCreer)
    sizer.Add(boutonCreer,(3,1),(1,1))
    sizer2.Add(sizer,1,wx.ALL|wx.EXPAND,20)
    pCreerBanque.SetSizerAndFit(sizer2)
    fCreerBanque.Fit()
    fCreerBanque.Show()

def fenetreCreerCompte(bId,cId):
    
    def onBoutonCreerCompte(event):
        if champIntitule.GetValue() or None or champnCompte.GetValue() or None or champMontant.GetValue() or None:
            c.execute("INSERT INTO comptes (cpt_bnqId,cpt_intitule,cpt_nCompte,cpt_montant) VALUES (?,?,?,?)",(bId,champIntitule.GetValue(),champnCompte.GetValue(),champMontant.GetValue(),))
            bdd.commit()
            fCreerCompte.Close()
            programme(bId,cId,pOperation)
                
    fCreerCompte = wx.Frame(fPrincipal,-1,"Créer un compte")
    pCreerCompte = wx.Panel(fCreerCompte,-1)
    
    sizer = wx.GridBagSizer(16,16)
    
    labelIntitule = wx.StaticText(pCreerCompte,-1,"Intitulé :")
    champIntitule = wx.TextCtrl(pCreerCompte,-1)
    sizer.Add(labelIntitule,(1,1),(1,1))
    sizer.Add(champIntitule,(1,2),(1,1))
    
    labelnCompte = wx.StaticText(pCreerCompte,-1,"Numéro :")
    champnCompte = wx.TextCtrl(pCreerCompte,-1)
    sizer.Add(labelnCompte,(2,1),(1,1))
    sizer.Add(champnCompte,(2,2),(1,1))
    
    labelMontant = wx.StaticText(pCreerCompte,-1,"Montant :")
    champMontant = wx.TextCtrl(pCreerCompte,-1)
    sizer.Add(labelMontant,(3,1),(1,1))
    sizer.Add(champMontant,(3,2),(1,1))
    
    boutonCreer = wx.Button(pCreerCompte,-1,"Créer un compte")
    fPrincipal.Bind(wx.EVT_BUTTON,onBoutonCreerCompte,boutonCreer)
    sizer.Add(boutonCreer,(4,2),(1,1))
    
    pCreerCompte.SetSizerAndFit(sizer)
    fCreerCompte.Fit()
    fCreerCompte.Show()

def fenetreCreerOperation(bId,cId,pOperation):
        
    def onBoutonCreerOperation(event):
        if champMotif.GetValue() or None or champMontant.GetValue() or None:
            c.execute("INSERT INTO operations (op_bnqId,op_cptId,op_type,op_reglement,op_motif,op_montant,op_date,op_etat) VALUES (?,?,?,?,?,?,?,'Non effectuee')",(bId,cId,champType.GetStringSelection(),champReglement.GetStringSelection(),champMotif.GetValue(),champMontant.GetValue(),dateO,))
            bdd.commit()
            fCreerOperation.Close()
            pOperation.Destroy()
            fPrincipal.Fit()
            programme(bId,cId,pOperation)
    
    def onChangerDate(event):
        selected = champDate.GetValue()
        jour = selected.Day
        mois = selected.Month + 1
        annee = selected.Year
        global dateO
        dateO = "%02d/%02d/%4d" % (jour,mois,annee)
            
    fCreerOperation = wx.Frame(fPrincipal,-1,"Créer une opération")
    pCreerOperation = wx.Panel(fCreerOperation,-1)
    
    sizer = wx.GridBagSizer(16,16)
    
    labelType = wx.StaticText(pCreerOperation,-1,"Type :")
    champType = wx.Choice(pCreerOperation,-1,choices=["Entrant","Sortant"])
    champType.SetSelection(0)
    sizer.Add(labelType,(1,1),(1,1))
    sizer.Add(champType,(1,2),(1,1))
    
    labelReglement = wx.StaticText(pCreerOperation,-1,"Réglement :")
    champReglement = wx.Choice(pCreerOperation,-1,choices=["Carte","Chèque","Virement"])
    champReglement.SetSelection(0)
    sizer.Add(labelReglement,(2,1),(1,1))
    sizer.Add(champReglement,(2,2),(1,1))
    
    labelMotif = wx.StaticText(pCreerOperation,-1,"Motif :")
    champMotif = wx.TextCtrl(pCreerOperation,-1)
    sizer.Add(labelMotif,(3,1),(1,1))
    sizer.Add(champMotif,(3,2),(1,1))
    
    labelMontant = wx.StaticText(pCreerOperation,-1,"Montant :")
    champMontant = wx.TextCtrl(pCreerOperation,-1)
    sizer.Add(labelMontant,(4,1),(1,1))
    sizer.Add(champMontant,(4,2),(1,1))
    
    labelDate = wx.StaticText(pCreerOperation,-1,"Date :")
    champDate = wx.DatePickerCtrl(pCreerOperation,-1)
    champDate.Bind(wx.EVT_DATE_CHANGED,onChangerDate)
    sizer.Add(labelDate,(5,1),(1,1))
    sizer.Add(champDate,(5,2),(1,1))
    
    boutonCreer = wx.Button(pCreerOperation,-1,"Créer une opération")
    fCreerOperation.Bind(wx.EVT_BUTTON,onBoutonCreerOperation,boutonCreer)
    sizer.Add(boutonCreer,(6,2),(1,1))
    
    pCreerOperation.SetSizerAndFit(sizer)
    fCreerOperation.Fit()
    fCreerOperation.Show()

def programme(bId,cId,pOperation):

    def onQuitter(event):
        fPrincipal.Close()
    
    def onCreerBanque(event):
        fenetreCreerBanque(bId,cId)
    
    def onChoixBanque(event):
        bId = event.GetId()
        cId = 0
        pOperation.Hide()
        programme(bId,cId,pOperation)
    
    def onSupprimerBanque(event):
        c.execute("DELETE FROM operations WHERE op_bnqId = ?",(bId,))
        c.execute("DELETE FROM comptes WHERE cpt_bnqId = ?",(bId,))
        c.execute("DELETE FROM banques WHERE bnq_id = ?",(bId,))
        bdd.commit()
        programme(bId,cId,pOperation)
    
    def onCreerCompte(event):
        fenetreCreerCompte(bId,cId)
    
    def onChoixCompte(event):
        cId = event.GetId()
        pOperation.Hide()
        programme(bId,cId,pOperation)
    
    def onSupprimerCompte(event,cId):
        c.execute("DELETE FROM operations WHERE op_cptId = ?",(cId,))
        c.execute("DELETE FROM comptes WHERE cpt_id = ?",(cId,))
        bdd.commit()
        programme(bId,cId,pOperation)
    
    def onCreerOperation(event):
        fenetreCreerOperation(bId,cId,pOperation)
    
    def onSupprimerOperation(event):
        oId = event.GetId()
        c.execute("DELETE FROM operations WHERE op_id = ?",(oId,))
        bdd.commit()
        pOperation.Show(False)
        fPrincipal.Fit()
        programme(bId,cId,pOperation)
    
    barreMenu = wx.MenuBar()
    
    mFichier = wx.Menu()
    quitter = mFichier.Append(-1,"Quitter","Mettre fin au programme")
    fPrincipal.Bind(wx.EVT_MENU,onQuitter,quitter)
    barreMenu.Append(mFichier,"Fichier")
    
    mBanques = wx.Menu()
    cBanque = mBanques.Append(-1,"Créer une banque")
    fPrincipal.Bind(wx.EVT_MENU,onCreerBanque,cBanque)
    mBanques.AppendSeparator()
    for a,b in c.execute("SELECT bnq_id,bnq_intitule FROM banques WHERE bnq_id != ?",(bId,)):
        a = mBanques.Append(a,b)
        fPrincipal.Bind(wx.EVT_MENU,onChoixBanque,a)
    mBanques.AppendSeparator()
    sBanque = mBanques.Append(-1,"Supprimer la banque en cours")
    fPrincipal.Bind(wx.EVT_MENU,onSupprimerBanque,sBanque)
    barreMenu.Append(mBanques,"Banques")
    
    if bId != 0:
        
        mComptes = wx.Menu()
        cCompte = mComptes.Append(-1,"Créer un compte")
        fPrincipal.Bind(wx.EVT_MENU,onCreerCompte,cCompte)
        mComptes.AppendSeparator()
        for a,b,d in c.execute("SELECT cpt_id,cpt_bnqId,cpt_intitule FROM comptes WHERE cpt_bnqId = ? and cpt_id != ?",(bId,cId)):
            a = mComptes.Append(a,d)
            fPrincipal.Bind(wx.EVT_MENU,onChoixCompte,a)
        mComptes.AppendSeparator()
        sCompte = mComptes.Append(-1,"Supprimer le compte en cours")
        fPrincipal.Bind(wx.EVT_MENU,onSupprimerCompte,sCompte)
        barreMenu.Append(mComptes,"Comptes")
        
    if cId != 0:
        
        date = time.strftime("%d/%m/%y")
        date = str(date)
        for a,b,d,e,f in c.execute("SELECT op_cptId, op_etat, op_type, op_date, op_montant FROM operations WHERE op_cptId = ? AND op_etat = 'Non effectuee'",(cId,)):
            if e <= date:
                if d == "Entrant":
                    c.execute("UPDATE comptes SET cpt_montant = cpt_montant + ? WHERE cpt_id = ?",(f,cId,))
                    bdd.commit()
                if d == "Sortant":
                    c.execute("UPDATE comptes SET cpt_montant = cpt_montant - ? WHERE cpt_id = ?",(f,cId))
                    bdd.commit()
                c.execute("UPDATE operations SET op_etat = 'Effectuee' ")
                bdd.commit()
        
        mOperations = wx.Menu()
        cOperation = mOperations.Append(-1,"Créer une opération")
        fPrincipal.Bind(wx.EVT_MENU,onCreerOperation,cOperation)
        barreMenu.Append(mOperations,"Opérations")
        pOperation = wx.Panel(fPrincipal)
        sizer = wx.GridBagSizer(16,16)
        sizer2 = wx.BoxSizer()
        font = wx.Font(13,wx.MODERN,wx.NORMAL,wx.NORMAL,False,u'Arial')
        font2 = wx.Font(13,wx.MODERN,wx.NORMAL,wx.NORMAL,False,u'Arial')
        montantCompteValeur = c.execute("SELECT cpt_montant FROM comptes WHERE cpt_id = ?",(cId,))
        montantCompte = wx.StaticText(pOperation,-1,"Montant du compte : 2500 euros",style=wx.TE_CENTRE)
        montantCompte.SetForegroundColour((175,0,0))
        montantCompte.SetFont(font2)
        type = wx.StaticText(pOperation,-1,"TYPE",style=wx.TE_CENTRE)
        type.SetFont(font)
        reglement = wx.StaticText(pOperation,-1,"REGLEMENT",style=wx.TE_CENTRE)
        reglement.SetFont(font)
        motif = wx.StaticText(pOperation,-1,"MOTIF",style=wx.TE_CENTRE)
        motif.SetFont(font)
        montant = wx.StaticText(pOperation,-1,"MONTANT",style=wx.TE_CENTRE)
        montant.SetFont(font)
        date = wx.StaticText(pOperation,-1,"DATE",style=wx.TE_CENTRE)
        date.SetFont(font)
        etat = wx.StaticText(pOperation,-1,"ETAT",style=wx.TE_CENTRE)
        etat.SetFont(font)
        sizer.Add(montantCompte,(0,0),(1,7))
        sizer.Add(type,(1,0),(1,1))
        sizer.Add(reglement,(1,1),(1,1))
        sizer.Add(motif,(1,2),(1,1))
        sizer.Add(montant,(1,3),(1,1))
        sizer.Add(date,(1,4),(1,1))
        sizer.Add(etat,(1,5),(1,1))
        x = 2
        for a,b,d,e,f,g,h,i in c.execute("SELECT op_id,op_cptId,op_type,op_reglement,op_motif,op_montant,op_date,op_etat FROM operations WHERE op_cptId = ?",(cId,)):
            typeO = wx.StaticText(pOperation,-1,d)
            reglementO = wx.StaticText(pOperation,-1,e)
            motifO = wx.StaticText(pOperation,-1,f)
            montantO = wx.StaticText(pOperation,-1,str(g))
            dateO = wx.StaticText(pOperation,-1,h)
            etatO = wx.StaticText(pOperation,-1,i)
            bouton = wx.Button(pOperation,a,"Supprimer")
            pOperation.Bind(wx.EVT_BUTTON,onSupprimerOperation,bouton)
            sizer.Add(typeO,(x,0),(1,1))
            sizer.Add(reglementO,(x,1),(1,1))
            sizer.Add(motifO,(x,2),(1,1))
            sizer.Add(montantO,(x,3),(1,1))
            sizer.Add(dateO,(x,4),(1,1))
            sizer.Add(etatO,(x,5),(1,1))
            sizer.Add(bouton,(x,6),(1,1))
            x += 1
        sizer2.Add(sizer,1,wx.ALL|wx.EXPAND,20)
        pOperation.SetSizerAndFit(sizer2)
        fPrincipal.Fit()
    
    fPrincipal.SetMenuBar(barreMenu)

programme(bId,cId,pOperation)

MyPersonalBank.MainLoop()