using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndAusentismo : BDconexion
    {
        public List<EIndAusentismo> Listar_IndAusentismo()
        {
            List<EIndAusentismo> lCIndAusentismo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndAusentismo oVIndAusentismo = new CIndAusentismo();
                    lCIndAusentismo = oVIndAusentismo.Listar_IndAusentismo(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndAusentismo);
        }
    }
}