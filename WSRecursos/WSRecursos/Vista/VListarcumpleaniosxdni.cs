using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarcumpleaniosxdni : BDconexion
    {
        public List<EListarcumpleaniosxdni> Listarcumpleaniosxdni(String dni)
        {
            List<EListarcumpleaniosxdni> lCListarcumpleaniosxdni = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarcumpleaniosxdni oVListarcumpleaniosxdni = new CListarcumpleaniosxdni();
                    lCListarcumpleaniosxdni = oVListarcumpleaniosxdni.Listarcumpleaniosxdni(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarcumpleaniosxdni);
        }
    }
}