using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VEmpresa : BDconexion
    {
        public List<EEmpresa> Listar_Empresa()
        {
            List<EEmpresa> lCEmpresa = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CEmpresa oVEmpresa = new CEmpresa();
                    lCEmpresa = oVEmpresa.Listar_Empresa(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEmpresa);
        }
    }
}