using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CCivil
    {
        public List<ECivil> Listar_Civil(SqlConnection con)
        {
            List<ECivil> lECivil = null;
            SqlCommand cmd = new SqlCommand("ASP_CIVIL", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lECivil = new List<ECivil>();

                ECivil obECivil = null;
                while (drd.Read())
                {
                    obECivil = new ECivil();
                    obECivil.i_id = drd["i_id"].ToString();
                    obECivil.v_nombre = drd["v_nombre"].ToString();
                    lECivil.Add(obECivil);
                }
                drd.Close();
            }

            return (lECivil);
        }
    }
}