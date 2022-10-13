using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VPais : BDconexion
    {
        public List<EPais> Listar_Pais()
        {
            List<EPais> lCPais = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CPais oVPais = new CPais();
                    lCPais = oVPais.Listar_Pais(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCPais);
        }
    }
}