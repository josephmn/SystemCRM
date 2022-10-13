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
    public class CCentroCosto
    {
        public List<ECentroCosto> Listar_CentroCosto(SqlConnection con)
        {
            List<ECentroCosto> lECentroCosto = null;
            SqlCommand cmd = new SqlCommand("ASP_CENTROCOSTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lECentroCosto = new List<ECentroCosto>();

                ECentroCosto obECentroCosto = null;
                while (drd.Read())
                {
                    obECentroCosto = new ECentroCosto();
                    obECentroCosto.i_id = drd["i_id"].ToString();
                    obECentroCosto.v_descripcion = drd["v_descripcion"].ToString();
                    obECentroCosto.v_default = drd["v_default"].ToString();
                    lECentroCosto.Add(obECentroCosto);
                }
                drd.Close();
            }

            return (lECentroCosto);
        }
    }
}